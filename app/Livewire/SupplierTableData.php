<?php

namespace App\Livewire;

use App\Models\Supplier;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierTableData extends Component
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
        $publisher = Supplier::find($id);
        $publisher->delete();

        session()->flash('success', 'Supplier successfully deleted!');
    }

     // ==========Add New Publisher============
     public $newPublisherName = null;
     public $newPublisherPhone = null;
     public $newPublisherGender = null;

     public function saveNewPublisher()
     {
         try {
             $validated = $this->validate([
                 'newPublisherName' => 'required|string|max:255',
             ]);

             Supplier::create([
                 'name' => $this->newPublisherName,
                 'phone' => $this->newPublisherPhone,
             ]);

             session()->flash('success', 'Add New Supplier successfully!');

             $this->reset(['newPublisherName', 'newPublisherGender', 'newPublisherPhone']);

         } catch (\Illuminate\Validation\ValidationException $e) {
             session()->flash('error', $e->validator->errors()->all());
         }
     }

     public $editId = null;
     public $name;
     public $gender;
     public $phone;

     public function setEdit($id) {
        $publisher = Supplier::find($id);
        $this->editId = $id;
        $this->name = $publisher->name;
        $this->gender = $publisher->gender;
        $this->phone = $publisher->phone;
     }

     public function cancelUpdatePublisher() {
        $this->editId = null;
        $this->name = null;
        $this->phone = null;
        $this->gender = null;
     }

     public function updatePublisher($id) {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
            ]);

            $publisher = Supplier::find($id);
            $publisher->update([
                'name' => $this->name,
                'phone' => $this->phone,
            ]);

            session()->flash('success', 'Supplier successfully edited!');

            $this->reset(['name', 'gender', 'editId']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
     }

    public function render(){

        $items = Supplier::where(function($query){
                                $query->where('name', 'LIKE', "%$this->search%");
                            })
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);

        return view('livewire.supplier-table-data', [
            'items' => $items,
        ]);
    }
}
