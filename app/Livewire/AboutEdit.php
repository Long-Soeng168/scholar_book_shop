<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\About;

class AboutEdit extends Component
{
    public $about; // Variable to hold the about record for editing
    public $name;
    public $description;
    public $description_kh;

    public function mount(About $about)
    {
        $this->about = $about; // Initialize the $about variable with the provided about model instance
        $this->name = $about->name;
        $this->description = $about->description;
        $this->description_kh = $about->description_kh;
    }

    public function save()
    {
        $this->dispatch('livewire:updated');
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'description_kh' => 'nullable',
        ]);

        // Update the existing about record
        $this->about->update($validated);

        session()->flash('success', 'about updated successfully!');

        // return redirect('admin/settings/about');
    }

    public function render()
    {
        return view('livewire.about-edit');
    }
}
