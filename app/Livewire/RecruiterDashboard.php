<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;

class RecruiterDashboard extends Component
{
    public $jobs;

    public function render()
    {
        $this->jobs = Job::where('user_id', Auth::id())
            ->withCount('applications')
            ->latest()
            ->get();

        return view('livewire.recruiter-dashboard');
    }

    public function closeJob($jobId)
    {
        $job = Job::where('user_id', Auth::id())->findOrFail($jobId);
        $job->update(['is_closed' => true]);
        session()->flash('message', 'Offre clôturée.');
    }

    public function deleteJob($jobId)
    {
        $job = Job::where('user_id', Auth::id())->findOrFail($jobId);
        $job->delete();
        session()->flash('message', 'Offre supprimée.');
    }
}
