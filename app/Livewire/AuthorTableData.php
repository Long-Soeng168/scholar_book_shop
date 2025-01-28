<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Author;

class AuthorTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $filter = 0;

    #[Url(history: true)]
    public $sortBy = 'created_at';

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
        $author = Author::find($id);
        $author->delete();

        session()->flash('success', 'Author successfully deleted!');
    }

     // ==========Add New Author============
     public $newAuthorName = null;
     public $newAuthorPhone = null;
     public $newAuthorGender = null;

     public function saveNewAuthor()
     {
         try {
             $validated = $this->validate([
                 'newAuthorName' => 'required|string|max:255',
             ]);

             Author::create([
                 'name' => $this->newAuthorName,
                 'gender' => $this->newAuthorGender,
                 'phone' => $this->newAuthorPhone,
             ]);

             session()->flash('success', 'Add New Author successfully!');

             $this->reset(['newAuthorName', 'newAuthorGender', 'newAuthorPhone']);

         } catch (\Illuminate\Validation\ValidationException $e) {
             session()->flash('error', $e->validator->errors()->all());
         }
     }

     public $editId = null;
     public $name;
     public $gender;
     public $phone;

     public function setEdit($id) {
        $author = Author::find($id);
        $this->editId = $id;
        $this->name = $author->name;
        $this->gender = $author->gender;
        $this->phone = $author->phone;
     }

     public function cancelUpdateAuthor() {
        $this->editId = null;
        $this->name = null;
        $this->gender = null;
        $this->phone = null;
     }

     public function updateAuthor($id) {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255',
            ]);

            $author = Author::find($id);
            $author->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone' => $this->phone,
            ]);

            session()->flash('success', 'Author successfully edited!');

            $this->reset(['name', 'gender', 'editId', 'phone']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
     }

    public function render(){

        $items = Author::where(function($query){
                                $query->where('name', 'LIKE', "%$this->search%");
                            })
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);

        return view('livewire.author-table-data', [
            'items' => $items,
        ]);
    }
}
