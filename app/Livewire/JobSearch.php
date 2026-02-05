<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;


class JobSearch extends Component
{
    public $search = '';

    public bool $open = false;
    public ?Job $selectedJob = null;

    public function showJob(int $jobId) 
    {
        $this->selectedJob = Job::findOrFail($jobId);
        $this->open = true;
    }

    public function closeModal() {
        $this->open = false;
        $this->selectedJob = null;
    }

    public function render()
        {
            $q = trim($this->search);
            
            $jobs = Job::query()
                ->when($q !== '', function ($query) use ($q) {
                    $query->where(function ($sub) use ($q) {
                        $sub->where('title', 'ilike', "%{$q}%")
                            ->orWhere('company', 'ilike', "%{$q}%");
                    });
                })
                ->latest()
                ->get();

            return view('livewire.job-search', [
                'jobs' => $jobs
            ]);
        }
}   