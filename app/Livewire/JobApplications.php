<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobApplications extends Component
{
    public $job;
    public $applications;

    public function mount($jobId)
    {
        $this->job = Job::with(['applications.user.profile'])->findOrFail($jobId);

        if ($this->job->user_id !== Auth::id()) {
            abort(403);
        }

        $this->applications = $this->job->applications;
    }

    public function render()
    {
        return view('livewire.job-applications');
    }
}
