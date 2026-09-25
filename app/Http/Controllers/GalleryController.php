<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $categories = GalleryAlbum::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        $query = GalleryAlbum::withCount('images')
            ->published();

        if ($request->filled('kategori')) {
            $query->where('category', $request->kategori);
        }

        $albums = $query->orderBy('event_date', 'desc')->paginate(9)->withQueryString();

        // Also fetch highlight photos for editorial mosaic
        $highlightImages = GalleryImage::with('album')
            ->whereHas('album', fn($q) => $q->published())
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('pages.gallery.index', compact('albums', 'categories', 'highlightImages'));
    }

    public function show($slug)
    {
        $album = GalleryAlbum::with(['images' => fn($q) => $q->orderBy('order', 'asc')])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $otherAlbums = GalleryAlbum::published()
            ->where('id', '!=', $album->id)
            ->orderBy('event_date', 'desc')
            ->take(3)
            ->get();

        return view('pages.gallery.show', compact('album', 'otherAlbums'));
    }
}
