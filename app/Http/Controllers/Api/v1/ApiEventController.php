<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ApiEventController extends Controller
{
    /**
     * Display a listing of the ressources.
     */
    public function index()
    {
        $events = Event::orderBy('date', 'asc')
            ->with('user')
            ->with('attendances')
            ->get();

        return $events;
    }

    /**
     * Store a newly created evressource in storage.
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
        ]);

        $event = new Event();
        $event->title       = $validated['title'];
        $event->description = $validated['description'] ?? null;
        $event->date        = $validated['date'];
        $event->location    = $validated['location'];
        $event->genre       = $validated['genre'] ?? null;
        $event->user()->associate($request->user());
        $event->save();

        return $event;
    }

    /**
     * Display the specified ressource.
     */
    public function show(string $id)
    {
        $event = Event::with('user')->with('attendances')->findOrFail($id);

        return $event;
    }

    /**
     * Update the specified ressource in storage.
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
        ]);

        $event->title       = $validated['title'];
        $event->description = $validated['description'] ?? null;
        $event->date        = $validated['date'];
        $event->location    = $validated['location'];
        $event->genre       = $validated['genre'] ?? null;
        $event->save();

        return $event;
    }

    /**
     * Remove the specified ressource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        Gate::authorize('delete', $event);

        $event->delete();

        return response()->noContent();
    }
}