<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentFeed extends Component
{
    public function render()
    {
        $studentsData = [];
        $students = Auth::user()->students()->get();

        foreach ($students as $student) {
            // Get latest analytic
            $latestAnalytic = $student->analytics()->latest()->first();

            // Defaults
            $status = 'OFFLINE';
            $score = 0;
            $time = now()->format('h:i A');
            $eyeOpen = false;
            $image = $student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=random';

            if ($latestAnalytic) {
                $time = $latestAnalytic->created_at->format('h:i A');

                // Calculate score
                if ($latestAnalytic->duration > 0) {
                    $score_val = ($latestAnalytic->focus_duration / $latestAnalytic->duration) * 100;
                    $score = round($score_val);
                } else {
                    $score = 0;
                }

                // Determine status based on score (mock logic for now, real logic might depend on threshold)
                if ($score >= 70) {
                    $status = 'FOCUSED';
                } elseif ($score >= 40) {
                    $status = 'LOW FOCUS';
                } else {
                    $status = 'DISTRACTED';
                }

                // Get latest capture for image/eye status
                $latestCapture = $latestAnalytic->captureHistory()->latest()->first();
                if ($latestCapture) {
                    // Assuming we might have eye status in future, for now mock based on status
                    $eyeOpen = $status !== 'DISTRACTED';
                    // Use capture image if available, else avatar
                    if ($latestCapture->image_path) {
                        $image = asset('storage/'.$latestCapture->image_path);
                    }
                }
            }

            $studentsData[] = [
                'id' => $student->id,
                'slug' => $student->slug,
                'name' => $student->name,
                'image' => $image,
                'status' => $status,
                'score' => $score,
                'time' => $time,
                'eye_open' => $eyeOpen,
            ];  
        }

        return view('livewire.student-feed', ['students' => $studentsData]);
    }
}
