<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contact;

class ContactEdit extends Component
{
    public $contact; // Variable to hold the Contact record for editing
    public $name;
    public $description;
    public $phone;
    public $email;
    public $map;
    public $address;

    public function mount(Contact $contact)
    {
        $thiscontact = $contact; // Initialize the $contact variable with the provided Contact model instance
        $this->name = $contact->name;
        $this->description = $contact->description;
        $this->phone = $contact->phone;
        $this->email = $contact->email;
        $this->map = $contact->map;
        $this->address = $contact->address;
    }

    public function save()
    {
        $this->dispatch('livewire:updated');
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'map' => 'nullable|string',
        ]);

        // Update the existing Contact record
        $this->contact->update($validated);

        session()->flash('success', 'Contact updated successfully!');

        // return redirect('admin/settings/Contact');
    }

    public function render()
    {
        return view('livewire.contact-edit');
    }
}
