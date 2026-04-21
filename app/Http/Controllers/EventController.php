<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::orderBy('date', 'asc')
            ->with('user')
            ->with('attendances')
            ->get();

        return view('events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        Gate::authorize('create', Event::class);

        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Event::class);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'date'        => ['required', 'date'],
            'location'    => ['required', 'string', 'max:255'],
            'genre'       => ['nullable', 'string', 'max:100'],
            'poster'      => ['nullable', 'image', 'max:4096'], // 4MB max
        ]);

        $file = $request->file('poster');

        if ($file) {
            $path = Storage::disk('public')->put('event-posters', $file);
            $validated['poster'] = $path;
        }

        $event = new Event();
        $event->title       = $validated['title'];
        $event->description = $validated['description'] ?? null;
        $event->date        = $validated['date'];
        $event->location    = $validated['location'];
        $event->genre       = $validated['genre'] ?? null;
        $event->poster      = $validated['poster'] ?? null;
        $event->user()->associate($request->user());
        $event->save();

        return redirect("/events/{$event->id}");
    }

    /**
     * Display the specified event.
     */
    public function show(string $id)
    {
        $event = Event::with('user')->with('attendances')->findOrFail($id);

        $user = Auth::user();
        $status = null;

        if ($user) {
            $attendance = $event->attendances()->where('user_id', $user->id)->first();
            if ($attendance) {
                $status = $attendance->pivot->status;
            }
        }

        return view('events.show', ['event' => $event, 'status' => $status]);
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        Gate::authorize('update', $event);

        return view('events.edit', ['event' => $event]);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        Gate::authorize('update', $event);

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'date'        => ['required', 'date'],
            'location'    => ['required', 'string', 'max:255'],
            'genre'       => ['nullable', 'string', 'max:100'],
            'poster'      => ['nullable', 'image', 'max:4096'],
        ]);

        $file = $request->file('poster');

        if ($file) {
            // Supprime l'ancienne affiche si elle existe
            if ($event->poster && Storage::disk('public')->exists($event->poster)) {
                Storage::disk('public')->delete($event->poster);
            }

            $path = Storage::disk('public')->put('event-posters', $file);
            $validated['poster'] = $path;
        }

        $event->title       = $validated['title'];
        $event->description = $validated['description'] ?? null;
        $event->date        = $validated['date'];
        $event->location    = $validated['location'];
        $event->genre       = $validated['genre'] ?? null;

        if (isset($validated['poster'])) {
            $event->poster = $validated['poster'];
        }

        $event->save();

        return redirect("/events/{$event->id}");
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        Gate::authorize('delete', $event);

        if ($event->poster && Storage::disk('public')->exists($event->poster)) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect('/events');
    }
}