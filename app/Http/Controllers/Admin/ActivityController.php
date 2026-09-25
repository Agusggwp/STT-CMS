<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('category');

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $activities = $query->latest('event_date')->paginate(10)->withQueryString();
        $categories = ActivityCategory::all();

        return view('admin.activities.index', compact('activities', 'categories'));
    }

    public function create()
    {
        $categories = ActivityCategory::all();
        return view('admin.activities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:activity_categories,id',
            'thumbnail' => 'nullable|image|max:3072',
            'thumbnail_url' => 'nullable|url',
            'description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['event_date'] = $validated['event_date'] ?? now();
        $validated['author_name'] = $validated['author_name'] ?? auth()->user()->name;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('activities', 'public');
            $validated['thumbnail'] = $path;
        } elseif (!empty($request->thumbnail_url)) {
            $validated['thumbnail'] = $request->thumbnail_url;
        }

        // Handle additional gallery images if uploaded
        $galleryImages = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $galleryImages[] = $file->store('activities/gallery', 'public');
            }
        }
        $validated['gallery_images'] = $galleryImages;

        $activity = Activity::create($validated);

        ActivityLog::record('create_activity', "Membuat kegiatan baru: {$activity->title}", $activity);

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Activity $activity)
    {
        $categories = ActivityCategory::all();
        return view('admin.activities.edit', compact('activity', 'categories'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:activity_categories,id',
            'thumbnail' => 'nullable|image|max:3072',
            'thumbnail_url' => 'nullable|url',
            'description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'author_name' => 'nullable|string|max:100',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('activities', 'public');
            $validated['thumbnail'] = $path;
        } elseif (!empty($request->thumbnail_url)) {
            $validated['thumbnail'] = $request->thumbnail_url;
        }

        if ($request->hasFile('gallery_files')) {
            $existing = $activity->gallery_images ?? [];
            foreach ($request->file('gallery_files') as $file) {
                $existing[] = $file->store('activities/gallery', 'public');
            }
            $validated['gallery_images'] = $existing;
        }

        $activity->update($validated);

        ActivityLog::record('update_activity', "Memperbarui kegiatan: {$activity->title}", $activity);

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Activity $activity)
    {
        $title = $activity->title;
        $activity->delete();

        ActivityLog::record('delete_activity', "Menghapus kegiatan: {$title}");

        return redirect()->route('admin.activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
