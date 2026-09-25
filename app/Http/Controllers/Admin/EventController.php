<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('q')) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->latest('event_date')->paginate(10)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'start_time' => 'nullable|string|max:50',
            'end_time' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'poster' => 'nullable|image|max:3072',
            'poster_url' => 'nullable|url',
            'registration_link' => 'nullable|url',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('events', 'public');
            $validated['poster'] = $path;
        } elseif (!empty($request->poster_url)) {
            $validated['poster'] = $request->poster_url;
        }

        $event = Event::create($validated);

        ActivityLog::record('create_event', "Menambahkan agenda: {$event->title}", $event);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'start_time' => 'nullable|string|max:50',
            'end_time' => 'nullable|string|max:50',
            'location' => 'required|string|max:255',
            'poster' => 'nullable|image|max:3072',
            'poster_url' => 'nullable|url',
            'registration_link' => 'nullable|url',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('events', 'public');
            $validated['poster'] = $path;
        } elseif (!empty($request->poster_url)) {
            $validated['poster'] = $request->poster_url;
        }

        $event->update($validated);

        ActivityLog::record('update_event', "Memperbarui agenda: {$event->title}", $event);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $title = $event->title;
        $event->delete();

        ActivityLog::record('delete_event', "Menghapus agenda: {$title}");

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
