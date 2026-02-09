<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Education;
use Illuminate\Support\Facades\Auth;

class ManageEducation extends Component
{
    public $educations;
    public $school, $degree, $field_of_study, $start_date, $end_date;
    public $education_id;
    public $isOpen = false;

    public function render()
    {
        $this->educations = Auth::user()->education()->orderBy('start_date', 'desc')->get();
        return view('livewire.manage-education');
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
        $this->school = '';
        $this->degree = '';
        $this->field_of_study = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->education_id = '';
    }

    public function store()
    {
        $this->validate([
            'school' => 'required',
            'degree' => 'required',
            'field_of_study' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Education::updateOrCreate(['id' => $this->education_id ?: null], [
            'user_id' => Auth::id(),
            'school' => $this->school,
            'degree' => $this->degree,
            'field_of_study' => $this->field_of_study,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        session()->flash('message', $this->education_id ? 'Éducation mise à jour.' : 'Éducation ajoutée.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $education = Education::findOrFail($id);
        if ($education->user_id !== Auth::id()) {
            abort(403);
        }
        $this->education_id = $id;
        $this->school = $education->school;
        $this->degree = $education->degree;
        $this->field_of_study = $education->field_of_study;
        $this->start_date = $education->start_date->format('Y-m-d');
        $this->end_date = $education->end_date ? $education->end_date->format('Y-m-d') : null;

        $this->openModal();
    }

    public function delete($id)
    {
        $education = Education::findOrFail($id);
        if ($education->user_id !== Auth::id()) {
            abort(403);
        }
        $education->delete();
        session()->flash('message', 'Éducation supprimée.');
    }
}
