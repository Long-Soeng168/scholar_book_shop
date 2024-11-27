<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\IsbnRequest;
use App\Models\IsbnRejectComment;

class IsbnTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'status';

    #[Url(history: true)]
    public $sortDir = 'ASC';

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
    public function delete($id) {
        $item = IsbnRequest::findOrFail($id);

        if($item->status == 1) {
            return session()->flash('error', ['Cannot Delete Approved Item!']);
        }
        $item->delete();

        IsbnRejectComment::where('isbn_id', $id)->delete();



        session()->flash('success', 'Successfully deleted!');
    }

    // ResetPage when updated search
    public function updatedSearch() {
        $this->resetPage();
    }

    public function render(){

        $items = IsbnRequest::where('title', 'LIKE', "%$this->search%")
        ->when(!request()->user()->hasRole(['admin', 'super-admin']), function($query) {
            $query->where('publisher_id', request()->user()->id);
        })
        ->when(request()->user()->hasRole(['admin', 'super-admin']), function($query) {
            $query->where('status', '!=', -1);
        })

        ->orderBy($this->sortBy, $this->sortDir)
        ->orderBy('id', 'DESC')
        ->paginate($this->perPage);




        return view('livewire.isbn-table-data', [
            'items' => $items,
        ]);
    }
}
