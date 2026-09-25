<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\WorkProgram;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $homePage = Page::where('slug', 'home')->first();
        $sections = PageSection::where('page_key', 'home')
            ->where('is_active', true)
            ->orderBy('order', 'asc')
            ->get()
            ->keyBy('section_key');

        $featuredActivities = Activity::with('category')
            ->published()
            ->orderBy('is_featured', 'desc')
            ->orderBy('event_date', 'desc')
            ->take(3)
            ->get();

        $latestNews = Post::with('category')
            ->published()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $upcomingEvents = Event::upcoming()
            ->take(3)
            ->get();

        $galleryAlbums = GalleryAlbum::with(['images' => function ($q) {
            $q->orderBy('order', 'asc');
        }])
            ->published()
            ->orderBy('order', 'asc')
            ->take(6)
            ->get();

        $workPrograms = WorkProgram::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('pages.home', compact(
            'homePage',
            'sections',
            'featuredActivities',
            'latestNews',
            'upcomingEvents',
            'galleryAlbums',
            'workPrograms'
        ));
    }
}
