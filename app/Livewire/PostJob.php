<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class PostJob extends Component
{
    use WithFileUploads;

    public $title, $company, $description, $contract_type, $image;
    public $selectedSkills = [];
    public $availableSkills = [];

    protected $rules = [
        'title' => 'required|min:5',
        'company' => 'required',
        'description' => 'required|min:20',
        'contract_type' => 'required|in:CDI,CDD,Stage,Freelance',
        'image' => 'nullable|image|max:1024',
        'selectedSkills' => 'array',
    ];

    public function mount()
    {
        $this->availableSkills = \App\Models\Skill::all();
    }

    public function save()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('jobs', 'public') : 'jobs/default.png';

        $job = Job::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'company' => $this->company,
            'description' => $this->description,
            'contract_type' => $this->contract_type,
            'image' => $imagePath,
        ]);

        if (!empty($this->selectedSkills)) {
            $job->skills()->attach($this->selectedSkills);
        }

        Session::flash('message', 'Offre publiée avec succès !');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.post-job');
    }
}