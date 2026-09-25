<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $categories = ActivityCategory::withCount(['activities' => function ($q) {
            $q->published();
        }])->get();

        $query = Activity::with('category')->published();

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $activities = $query->orderBy('event_date', 'desc')->paginate(9)->withQueryString();

        return view('pages.activities.index', compact('activities', 'categories'));
    }

    public function show($slug)
    {
        $activity = Activity::with('category')->where('slug', $slug)->published()->firstOrFail();

        $relatedActivities = Activity::with('category')
            ->published()
            ->where('id', '!=', $activity->id)
            ->where('category_id', $activity->category_id)
            ->take(3)
            ->get();

        return view('pages.activities.show', compact('activity', 'relatedActivities'));
    }
}
