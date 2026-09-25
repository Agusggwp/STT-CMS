<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::upcoming()->get();
        $pastEvents = Event::past()->paginate(6, ['*'], 'past_page');

        return view('pages.events.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $otherEvents = Event::where('id', '!=', $event->id)->upcoming()->take(3)->get();

        return view('pages.events.show', compact('event', 'otherEvents'));
    }
}
