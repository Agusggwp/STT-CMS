<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageSectionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_id' => 'nullable|exists:pages,id',
            'page_key' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:text,image,text_image,gallery,event,news,cta,faq,statistics,custom',
            'content' => 'nullable|string',
            'data' => 'nullable|array',
        ]);

        $maxOrder = PageSection::where('page_key', $validated['page_key'])->max('order') ?? 0;
        $validated['order'] = $maxOrder + 1;
        $validated['section_key'] = Str::slug($validated['title']) . '_' . Str::random(4);
        $validated['is_active'] = true;

        $section = PageSection::create($validated);

        ActivityLog::record('add_section', "Menambahkan bagian '{$section->title}' pada halaman {$section->page_key}", $section);

        return redirect()->back()->with('success', 'Bagian section baru berhasil ditambahkan!');
    }

    public function update(Request $request, PageSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'data' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // Handle possible image upload in section data
        if ($request->hasFile('section_image')) {
            $path = $request->file('section_image')->store('sections', 'public');
            $data = $section->data ?? [];
            $data['image'] = asset('storage/' . $path);
            $validated['data'] = $data;
        }

        $section->update($validated);

        ActivityLog::record('update_section', "Memperbarui bagian '{$section->title}'", $section);

        return redirect()->back()->with('success', 'Bagian section berhasil diperbarui!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:page_sections,id',
            'sections.*.order' => 'required|integer',
        ]);

        foreach ($request->sections as $item) {
            PageSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['status' => 'success', 'message' => 'Urutan berhasil disimpan.']);
    }

    public function toggle(PageSection $section)
    {
        $section->update(['is_active' => !$section->is_active]);

        $status = $section->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLog::record('toggle_section', "Bagian '{$section->title}' {$status}", $section);

        return redirect()->back()->with('success', "Bagian section berhasil {$status}!");
    }

    public function destroy(PageSection $section)
    {
        $title = $section->title;
        $section->delete();

        ActivityLog::record('delete_section', "Menghapus bagian '{$title}'");

        return redirect()->back()->with('success', 'Bagian section berhasil dihapus.');
    }
}
