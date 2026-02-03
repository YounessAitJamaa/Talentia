<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Job;

class JobSearch extends Component
{
    public $search = '';

    public function render()
        {
            
            $jobs = Job::where('title', 'ilike', '%' . $this->search . '%')
                        ->orWhere('company', 'ilike', '%' . $this->search . '%')
                        ->latest()
                        ->get();

            return view('livewire.job-search', [
                'jobs' => $jobs
            ]);
        }
}