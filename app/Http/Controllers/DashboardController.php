<?php

namespace App\Http\Controllers;

use App\Models\Analytic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        $activeStudentsCount = $teacher->students()->count();
        $totalStudents = $teacher->students()->count();

        $studentIds = $teacher->students()->pluck('users.id');
        $analytics = Analytic::whereIn('user_id', $studentIds)->where('duration', '>', 0)->get();

        $totalScore = 0;
        $count = $analytics->count();

        foreach ($analytics as $analytic) {
            $score = ($analytic->focus_duration / $analytic->duration) * 100;
            $totalScore += $score;
        }

        $avgEngagement = $count > 0 ? round($totalScore / $count) : 0;

        // Alerts Today
        // Count analytics created today with low focus (< 50%) FOR THIS TEACHER'S STUDENTS
        $alertsToday = Analytic::whereIn('user_id', $studentIds)
            ->whereDate('created_at', today())
            ->where('duration', '>', 0)
            ->whereRaw('(focus_duration / duration) * 100 < 50')
            ->count();

        return view('dashboard.index', compact('activeStudentsCount', 'totalStudents', 'avgEngagement', 'alertsToday'));
    }

    public function show(User $user)
    {
        // Ensure the student belongs to the authenticated teacher
        $teacher = Auth::user();
        if (! $teacher->students()->where('student_id', $user->id)->exists()) {
            abort(403, 'Unauthorized access to this student.');
        }

        // Fetch Analytics
        $analytics = $user->analytics()->orderBy('created_at', 'desc')->get();

        // Calculate Stats
        $totalSessions = $analytics->count();
        $totalDuration = $analytics->sum('duration');
        $totalFocus = $analytics->sum('focus_duration');
        $avgFocusScore = $totalDuration > 0 ? round(($totalFocus / $totalDuration) * 100) : 0;

        // Latest Session for status
        $latestAnalytic = $analytics->first();
        $status = 'OFFLINE';
        if ($latestAnalytic && $latestAnalytic->created_at->isToday()) {
            // Simple check if recent, logic can be improved
            $status = 'RECENTLY ACTIVE';
        }

        return view('dashboard.detail', [
            'student' => $user,
            'analytics' => $analytics,
            'totalSessions' => $totalSessions,
            'avgFocusScore' => $avgFocusScore,
            'status' => $status,
        ]);
    }
}
