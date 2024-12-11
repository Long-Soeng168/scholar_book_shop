<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Order;

class OrderTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

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
    public function delete($id) {
        $item = Link::findOrFail($id);
        $item->delete();

        session()->flash('success', 'Successfully deleted!');
    }

    // ResetPage when updated search
    public function updatedSearch() {
        $this->resetPage();
    }
    
    public function updateStatus($itemId, $status)
    {
        // Your logic here, e.g., updating a record in the database
        $item = Order::find($itemId);
        if ($item) {
            $item->status = $status;
            $item->save();
        }

        // Optionally, emit an event or set a flash message
        session()->flash('success', 'Status updated successfully.');
    }

    public function render(){

        $items = Order::where(function($query){
                                $query->where('name', 'LIKE', "%$this->search%")
                                      ->orWhere('phone', 'LIKE', "%$this->search%");
                            })
                            ->orderBy($this->sortBy, $this->sortDir)
                            ->paginate($this->perPage);

        return view('livewire.order-table-data', [
            'items' => $items,
        ]);
    }
}
