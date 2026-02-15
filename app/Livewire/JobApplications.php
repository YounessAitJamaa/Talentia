<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;
use App\Models\Application;
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

    public function accept($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        // Ensure the recruiter owns the job
        if ($application->job->user_id !== Auth::id()) {
            abort(403);
        }

        $application->update(['status' => 'accepted']);
        $this->refreshApplications();
        session()->flash('message', 'Candidature acceptée.');
    }

    public function refuse($applicationId)
    {
        $application = Application::findOrFail($applicationId);

        // Ensure the recruiter owns the job
        if ($application->job->user_id !== Auth::id()) {
            abort(403);
        }

        $application->update(['status' => 'refused']);
        $this->refreshApplications();
        session()->flash('message', 'Candidature refusée.');
    }

    private function refreshApplications()
    {
        $this->applications = Application::where('job_id', $this->job->id)
            ->with('user.profile')
            ->get();
    }

    public function render()
    {
        return view('livewire.job-applications');
    }
}
