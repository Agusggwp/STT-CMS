<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Document;
use App\Models\Event;
use App\Models\GalleryAlbum;
use App\Models\Member;
use App\Models\Post;
use App\Models\WorkProgram;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts_count' => Post::count(),
            'activities_count' => Activity::count(),
            'events_count' => Event::count(),
            'members_count' => Member::where('is_active', true)->count(),
            'albums_count' => GalleryAlbum::count(),
            'documents_count' => Document::count(),
            'programs_count' => WorkProgram::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];

        $recentActivities = Activity::with('category')->latest('event_date')->take(5)->get();
        $recentPosts = Post::with('category')->latest('published_at')->take(5)->get();
        $upcomingEvents = Event::upcoming()->take(4)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentLogs = ActivityLog::with('user')->latest('created_at')->take(8)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentActivities',
            'recentPosts',
            'upcomingEvents',
            'recentMessages',
            'recentLogs'
        ));
    }
}
