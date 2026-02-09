<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class ManageSkills extends Component
{
    public $skills;
    public $skill_name;

    public function render()
    {
        $this->skills = Auth::user()->skills;
        return view('livewire.manage-skills');
    }

    public function addSkill()
    {
        $this->validate([
            'skill_name' => 'required|string|min:2',
        ]);

        $skill = Skill::firstOrCreate(['name' => $this->skill_name]);

        if (!Auth::user()->skills->contains($skill->id)) {
            Auth::user()->skills()->attach($skill->id);
            session()->flash('message', 'Compétence ajoutée.');
        } else {
            session()->flash('message', 'Vous avez déjà cette compétence.');
        }

        $this->skill_name = '';
    }

    public function removeSkill($skillId)
    {
        Auth::user()->skills()->detach($skillId);
        session()->flash('message', 'Compétence retirée.');
    }
}
