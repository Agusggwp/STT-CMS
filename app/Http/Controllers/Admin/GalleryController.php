<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryAlbum::withCount('images');

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $albums = $query->orderBy('order', 'asc')->latest('event_date')->paginate(10)->withQueryString();

        return view('admin.gallery.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
            'cover_image_url' => 'nullable|url',
            'event_date' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'photos.*' => 'nullable|image|max:4096',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('albums', 'public');
            $validated['cover_image'] = $path;
        } elseif (!empty($request->cover_image_url)) {
            $validated['cover_image'] = $request->cover_image_url;
        }

        $album = GalleryAlbum::create($validated);

        if ($request->hasFile('photos')) {
            $order = 1;
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('albums/photos', 'public');
                GalleryImage::create([
                    'album_id' => $album->id,
                    'image_path' => $path,
                    'order' => $order++,
                ]);
            }
        }

        ActivityLog::record('create_album', "Membuat album galeri: {$album->title}", $album);

        return redirect()->route('admin.gallery.edit', $album)->with('success', 'Album galeri berhasil dibuat!');
    }

    public function edit(GalleryAlbum $album)
    {
        $album->load(['images' => fn($q) => $q->orderBy('order', 'asc')]);
        return view('admin.gallery.edit', compact('album'));
    }

    public function update(Request $request, GalleryAlbum $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
            'cover_image_url' => 'nullable|url',
            'event_date' => 'nullable|date',
            'status' => 'required|in:published,draft',
            'photos.*' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('albums', 'public');
            $validated['cover_image'] = $path;
        } elseif (!empty($request->cover_image_url)) {
            $validated['cover_image'] = $request->cover_image_url;
        }

        $album->update($validated);

        if ($request->hasFile('photos')) {
            $maxOrder = $album->images()->max('order') ?? 0;
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('albums/photos', 'public');
                GalleryImage::create([
                    'album_id' => $album->id,
                    'image_path' => $path,
                    'order' => ++$maxOrder,
                ]);
            }
        }

        ActivityLog::record('update_album', "Memperbarui album galeri: {$album->title}", $album);

        return redirect()->route('admin.gallery.edit', $album)->with('success', 'Album galeri berhasil diperbarui!');
    }

    public function deleteImage(GalleryImage $image)
    {
        $albumId = $image->album_id;
        $image->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari album.');
    }

    public function destroy(GalleryAlbum $album)
    {
        $title = $album->title;
        $album->delete();

        ActivityLog::record('delete_album', "Menghapus album galeri: {$title}");

        return redirect()->route('admin.gallery.index')->with('success', 'Album galeri berhasil dihapus.');
    }
}
