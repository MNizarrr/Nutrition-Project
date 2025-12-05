<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use App\Models\UserExerciseSession;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserExerciseController extends Controller
{
    public function start($activityId)
    {
        $activity = PhysicalActivity::findOrFail($activityId);
        return view('user.exercise.start', compact('activity'));
    }

    public function finish(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:physical_activities,id',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $activity = PhysicalActivity::findOrFail($request->activity_id);
        $caloriesBurned = ($activity->calories_burned / 60) * $request->duration_minutes;

        $session = UserExerciseSession::create([
            'user_id' => auth()->id(),
            'physical_activity_id' => $request->activity_id,
            'duration_minutes' => $request->duration_minutes,
            'calories_burned' => round($caloriesBurned, 2),
            'started_at' => now(),
            'finished_at' => now(),
        ]);

        return redirect()->route('user.exercise.complete', $session->id);
    }

    public function complete($sessionId)
    {
        $session = UserExerciseSession::with('physicalActivity')->findOrFail($sessionId);

        // Ensure the session belongs to the authenticated user
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.exercise.complete', compact('session'));
    }

    public function exportPDF($sessionId)
    {
        $session = UserExerciseSession::with(['physicalActivity', 'user'])->findOrFail($sessionId);

        // Ensure the session belongs to the authenticated user
        if ($session->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.exercise.pdf', compact('session'));

        return $pdf->download('exercise-summary-' . $session->id . '.pdf');
    }
}
