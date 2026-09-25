<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticUrls = [
            url('/'),
            url('/tentang'),
            url('/struktur'),
            url('/pengurus'),
            url('/kegiatan'),
            url('/agenda'),
            url('/galeri'),
            url('/berita'),
            url('/program-kerja'),
            url('/dokumen'),
            url('/kontak'),
        ];

        $posts = Post::published()->select('slug', 'updated_at')->get();
        $activities = Activity::published()->select('slug', 'updated_at')->get();
        $events = Event::select('slug', 'updated_at')->get();
        $albums = GalleryAlbum::published()->select('slug', 'updated_at')->get();
        $pages = Page::where('status', 'published')->where('is_system', false)->select('slug', 'updated_at')->get();

        $content = view('seo.sitemap', compact(
            'staticUrls',
            'posts',
            'activities',
            'events',
            'albums',
            'pages'
        ))->render();

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /login\n\nSitemap: " . url('/sitemap.xml');
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
