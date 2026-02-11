<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ManageExperience extends Component
{
    public $experiences;
    public $company, $position, $description, $start_date, $end_date;
    public $experience_id;
    public $isOpen = false;

    public function render()
    {
        $this->experiences = Auth::user()->experiences()->orderBy('start_date', 'desc')->get();
        return view('livewire.manage-experience');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->company = '';
        $this->position = '';
        $this->description = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->experience_id = '';
    }

    public function store()
    {
        $this->validate([
            'company' => 'required',
            'position' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        Experience::updateOrCreate(['id' => $this->experience_id ?: null], [
            'user_id' => Auth::id(),
            'company' => $this->company,
            'position' => $this->position,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        session()->flash('message', $this->experience_id ? 'Expérience mise à jour.' : 'Expérience ajoutée.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $experience = Experience::findOrFail($id);
        if ($experience->user_id !== Auth::id()) {
            abort(403);
        }
        $this->experience_id = $id;
        $this->company = $experience->company;
        $this->position = $experience->position;
        $this->description = $experience->description;
        $this->start_date = $experience->start_date->format('Y-m-d');
        $this->end_date = $experience->end_date ? $experience->end_date->format('Y-m-d') : null;

        $this->openModal();
    }

    public function delete($id)
    {
        $experience = Experience::findOrFail($id);
        if ($experience->user_id !== Auth::id()) {
            abort(403);
        }
        $experience->delete();
        session()->flash('message', 'Expérience supprimée.');
    }
}
