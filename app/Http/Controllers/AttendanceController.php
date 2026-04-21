<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:going,interested'],
        ]);

        $event = Event::findOrFail($id);
        $user = $request->user();
        $status = $validated['status'];

        // Vérifie si l'utilisateur a déjà une participation à cet event
        $existingAttendance = $event->attendances()
            ->where('user_id', $user->id)
            ->first();

        if ($existingAttendance) {
            // Même status -> (toggle off)
            if ($existingAttendance->pivot->status === $status) {
                $event->attendances()->detach($user->id);
            } else {
                // Status différent -> mise à jour
                $event->attendances()->updateExistingPivot($user->id, ['status' => $status]);
            }
        } else {
            // Pas de participation -> création
            $event->attendances()->attach($user->id, ['status' => $status]);
        }

        return redirect("/events/{$id}");
    }
}