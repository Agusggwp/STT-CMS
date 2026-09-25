<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except([
            '_token',
            '_method',
            'logo',
            'site_logo',
            'favicon',
            'site_favicon',
            'remove_logo',
            'remove_favicon',
        ]);

        foreach ($data as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            $group = $setting ? $setting->group : 'general';
            $type = $setting ? $setting->type : 'text';
            $label = $setting ? $setting->label : null;

            SiteSetting::set($key, (string) $value, $group, $type, $label);
        }

        // Support both naming conventions for compatibility
        if (isset($data['site_name'])) {
            SiteSetting::set('org_name', $data['site_name'], 'general', 'text', 'Nama Organisasi');
        }
        if (isset($data['org_short_name'])) {
            SiteSetting::set('site_short_name', $data['org_short_name'], 'general', 'text', 'Nama Pendek');
        }

        // Handle Remove Logo
        if ($request->boolean('remove_logo')) {
            SiteSetting::set('logo', '', 'general', 'image', 'Logo Organisasi');
            SiteSetting::set('site_logo', '', 'general', 'image', 'Logo Organisasi');
        }

        // Handle Logo Upload
        if ($request->hasFile('site_logo') || $request->hasFile('logo')) {
            $file = $request->file('site_logo') ?? $request->file('logo');
            $path = $file->store('site', 'public');
            $url = asset('storage/' . $path);
            SiteSetting::set('logo', $url, 'general', 'image', 'Logo Organisasi');
            SiteSetting::set('site_logo', $url, 'general', 'image', 'Logo Organisasi');
        }

        // Handle Remove Favicon
        if ($request->boolean('remove_favicon')) {
            SiteSetting::set('favicon', '', 'general', 'image', 'Favicon');
            SiteSetting::set('site_favicon', '', 'general', 'image', 'Favicon');
        }

        // Handle Favicon Upload
        if ($request->hasFile('site_favicon') || $request->hasFile('favicon')) {
            $file = $request->file('site_favicon') ?? $request->file('favicon');
            $path = $file->store('site', 'public');
            $url = asset('storage/' . $path);
            SiteSetting::set('favicon', $url, 'general', 'image', 'Favicon');
            SiteSetting::set('site_favicon', $url, 'general', 'image', 'Favicon');
        }

        ActivityLog::record('update_settings', 'Memperbarui pengaturan website dan identitas logo');

        return redirect()->back()->with('success', 'Pengaturan website dan logo berhasil disimpan!');
    }
}
