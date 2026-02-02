<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddStudentModal extends Component
{
    public $isOpen = false;
    public $search = '';
    public $message = '';
    public $messageType = ''; // 'success' or 'error'

    protected $listeners = ['openAddStudentModal' => 'openModal'];

    public function openModal()
    {
        $this->isOpen = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->search = '';
        $this->message = '';
        $this->messageType = '';
    }

    public function addStudent()
    {
        $this->validate([
            'search' => 'required|string|min:3',
        ]);

        $search = $this->search;

        $student = User::where('role', 'student')
            ->where(function ($query) use ($search) {
                $query->where('email', $search)
                      ->orWhere('username', $search)
                      ->orWhere('name', 'like', '%' . $search . '%');
            })
            ->first();

        if (!$student) {
            $this->message = 'Student not found.';
            $this->messageType = 'error';
            return;
        }

        // Check if already added
        if (Auth::user()->students()->where('student_id', $student->id)->exists()) {
            $this->message = 'Student is already in your list.';
            $this->messageType = 'error';
            return;
        }

        Auth::user()->students()->attach($student->id);

        $this->message = "Successfully added {$student->name}!";
        $this->messageType = 'success';
        $this->search = '';

        // Emit event to refresh student feed if needed
        // $this->emit('studentAdded'); 
    }

    public function render()
    {
        return view('livewire.add-student-modal');
    }
}
