<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentManager extends Component
{
    public $username = '';

    public $errorMessage = '';

    public $successMessage = '';

    public function addStudent()
    {
        $this->resetMessages();

        $this->validate([
            'username' => 'required|string|min:3',
        ]);

        $student = User::where('role', 'student')
            ->where(function ($query) {
                $query->where('username', 'like', '%'.$this->username.'%')
                    ->orWhere('email', 'like', '%'.$this->username.'%')
                    ->orWhere('name', 'like', '%'.$this->username.'%');
            })
            ->first();

        if (! $student) {
            $this->errorMessage = 'Student not found with this username or email.';

            return;
        }

        // Check if already added
        if (Auth::user()->students()->where('student_id', $student->id)->exists()) {
            $this->errorMessage = 'Student is already in your list.';

            return;
        }

        Auth::user()->students()->attach($student->id);

        $this->successMessage = 'Student added successfully!';
        $this->username = '';
    }

    public function removeStudent($studentId)
    {
        Auth::user()->students()->detach($studentId);
        $this->successMessage = 'Student removed from your list.';
    }

    public function resetMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function render()
    {
        return view('livewire.student-manager', [
            'students' => Auth::user()->students()->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
