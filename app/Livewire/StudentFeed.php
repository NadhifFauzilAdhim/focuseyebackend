<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentFeed extends Component
{
    public function render()
    {
        $studentsData = [];
        $students = Auth::user()->students()->get();

        foreach ($students as $student) {
            $latestAnalytic = $student->analytics()->latest()->first();

            $status = 'OFFLINE';
            $score = 0;
            $time = now()->format('h:i A');
            $eyeOpen = false;
            $image = $student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=random';

            if ($latestAnalytic) {
                $time = $latestAnalytic->created_at->format('h:i A');

                if ($latestAnalytic->duration > 0) {
                    $score_val = ($latestAnalytic->focus_duration / $latestAnalytic->duration) * 100;
                    $score = round($score_val);
                } else {
                    $score = 0;
                }

                if ($score >= 70) {
                    $status = 'FOCUSED';
                } elseif ($score >= 40) {
                    $status = 'LOW FOCUS';
                } else {
                    $status = 'DISTRACTED';
                }

                $latestCapture = $latestAnalytic->captureHistory()->latest()->first();
                if ($latestCapture) {
                    $eyeOpen = $status !== 'DISTRACTED';
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
