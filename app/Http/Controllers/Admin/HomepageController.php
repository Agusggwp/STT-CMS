<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $homePage = Page::where('slug', 'home')->first();
        $sections = PageSection::where('page_key', 'home')->orderBy('order', 'asc')->get();

        $heroSettings = SiteSetting::where('group', 'hero')->pluck('value', 'key');
        $footerSettings = SiteSetting::where('group', 'footer')->pluck('value', 'key');

        return view('admin.homepage.index', compact('homePage', 'sections', 'heroSettings', 'footerSettings'));
    }

    public function updateHero(Request $request)
    {
        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:200',
            'hero_title_prefix' => 'nullable|string|max:200',
            'hero_headline' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'hero_cta_primary_text' => 'nullable|string|max:100',
            'hero_cta_primary_url' => 'nullable|string|max:200',
            'hero_cta_secondary_text' => 'nullable|string|max:100',
            'hero_cta_secondary_url' => 'nullable|string|max:200',
            'hero_image' => 'nullable|image|max:4096',
            'hero_image_url' => 'nullable|url',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'hero_image' || $key === 'hero_image_url') continue;
            SiteSetting::set($key, $value, 'hero', 'text');
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('hero', 'public');
            SiteSetting::set('hero_image', asset('storage/' . $path), 'hero', 'image');
        } elseif (!empty($request->hero_image_url)) {
            SiteSetting::set('hero_image', $request->hero_image_url, 'hero', 'image');
        }

        ActivityLog::record('update_homepage_hero', 'Memperbarui konfigurasi Hero Beranda');

        return redirect()->back()->with('success', 'Hero Beranda berhasil diperbarui!');
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'footer_about' => 'nullable|string',
            'footer_copyright' => 'nullable|string|max:255',
            'footer_dev_credit' => 'nullable|string|max:255',
            'footer_dev_url' => 'nullable|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value, 'footer', 'text');
        }

        ActivityLog::record('update_homepage_footer', 'Memperbarui konfigurasi Footer');

        return redirect()->back()->with('success', 'Footer berhasil diperbarui!');
    }
}
