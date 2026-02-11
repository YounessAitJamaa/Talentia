<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplyJob extends Component
{
    use WithFileUploads;

    public $job;
    public $message;
    public $cv;
    public $isOpen = false;

    public function mount(Job $job)
    {
        $this->job = $job;
    }

    public function render()
    {
        return view('livewire.apply-job');
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['message', 'cv']);
    }

    public function submit()
    {
        $this->validate([
            'message' => 'nullable|string',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = $this->cv->store('cvs', 'public');

        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $this->job->id,
            'message' => $this->message,
            'cv_path' => $cvPath,
        ]);

        session()->flash('message', 'Candidature envoyée avec succès !');
        $this->closeModal();
    }
}
