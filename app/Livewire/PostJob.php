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

    protected $rules = [
        'title' => 'required|min:5',
        'company' => 'required',
        'description' => 'required|min:20',
        'contract_type' => 'required|in:CDI,CDD,Stage,Freelance',
        'image' => 'nullable|image|max:1024',
    ];

    public function save()
    {
        
    $this->validate(); 

        $imagePath = $this->image ? $this->image->store('jobs', 'public') : 'jobs/default.png';

        Job::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'company' => $this->company,
            'description' => $this->description,
            'contract_type' => $this->contract_type,
            'image' => $imagePath,
        ]);

        Session::flash('message', 'Offre publiée avec succès !');
        
        return redirect()->route('dashboard');
    }
    
    public function render()
    {
        return view('livewire.post-job');
    }
}