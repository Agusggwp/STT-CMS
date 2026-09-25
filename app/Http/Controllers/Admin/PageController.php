<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::withCount('sections')->orderBy('order', 'asc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'status' => 'required|in:published,draft',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);

        $page = Page::create($validated);

        ActivityLog::record('create_page', "Membuat halaman: {$page->title}", $page);

        return redirect()->route('admin.pages.builder', $page)->with('success', 'Halaman berhasil dibuat. Silakan atur bagian/section konten!');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'status' => 'required|in:published,draft',
        ]);

        $page->update($validated);

        ActivityLog::record('update_page', "Memperbarui halaman: {$page->title}", $page);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui!');
    }

    public function builder(Page $page)
    {
        $page->load(['sections' => fn($q) => $q->orderBy('order', 'asc')]);
        return view('admin.pages.builder', compact('page'));
    }

    public function destroy(Page $page)
    {
        if ($page->is_system) {
            return redirect()->back()->with('error', 'Halaman sistem tidak dapat dihapus.');
        }

        $title = $page->title;
        $page->delete();

        ActivityLog::record('delete_page', "Menghapus halaman: {$title}");

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
