<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $filter = 0;

    #[Url(history: true)]
    public $sortBy = 'id';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function setFilter($value) {
        $this->filter = $value;
        $this->resetPage();
    }

    public function setSortBy($newSortBy) {
        if($this->sortBy == $newSortBy){
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        }else{
            $this->sortBy = $newSortBy;
        }
    }

    // ResetPage when updated search
    public function updatedSearch() {
        $this->resetPage();
    }

    public function delete($id)
    {
        $publisher = Customer::find($id);
        $publisher->delete();

        session()->flash('success', 'Customer successfully deleted!');
    }

     // ==========Add New Publisher============
     public $newPublisherName = null;
     public $newPublisherPhone = null;
     public $newPublisherAddress = null;
     public $newPublisherGender = null;

     public function saveNewPublisher()
     {
         try {
             $validated = $this->validate([
                 'newPublisherName' => 'required|string|max:255',
             ]);

             Customer::create([
                 'name' => $this->newPublisherName,
                 'gender' => $this->newPublisherGender,
                 'address' => $this->newPublisherAddress,
                 'phone' => $this->newPublisherPhone,
             ]);

             session()->flash('success', 'Add New Customer successfully!');

             $this->reset(['newPublisherName', 'newPublisherGender', 'newPublisherPhone', 'newPublisherAddress']);

         } catch (\Illuminate\Validation\ValidationException $e) {
             session()->flash('error', $e->validator->errors()->all());
         }
     }

     public $editId = null;
     public $name;
     public $gender;
     public $address;
     public $phone;

     public function setEdit($id) {
        $publisher = Customer::find($id);
        $this->editId = $id;
        $this->name = $publisher->name;
        $this->gender = $publisher->gender;
        $this->phone = $publisher->phone;
        $this->address = $publisher->address;
     }

     public function cancelUpdatePublisher() {
        $this->editId = null;
        $this->name = null;
        $this->phone = null;
        $this->gender = null;
        $this->address = null;
     }

     public function updatePublisher($id) {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
            ]);

            $publisher = Customer::find($id);
            $publisher->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            session()->flash('success', 'Customer successfully edited!');

            $this->reset(['name', 'gender', 'editId', 'address']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
     }

    public function render(){

        $items = Customer::where(function($query){
                                $query->where('name', 'LIKE', "%$this->search%");
                            })
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);

        return view('livewire.customer-table-data', [
            'items' => $items,
        ]);
    }
}
