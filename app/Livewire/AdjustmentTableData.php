<?php

namespace App\Livewire;

use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;

class AdjustmentTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'adjustment_date';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function setFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function setSortBy($newSortBy)
    {
        if ($this->sortBy == $newSortBy) {
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        } else {
            $this->sortBy = $newSortBy;
        }
    }
    public function delete($id)
    {
        $item = Adjustment::findOrFail($id);
        $getedProducts = AdjustmentItem::where('adjustment_id', $id)->get();
        foreach ($getedProducts as $product) {
            $book = Book::find($product->product_id);
            if ($product->action == 'add') {
                $book->update([
                    'quantity' => $book->quantity - $product->quantity,
                ]);
            } elseif ($product->action == 'minus') {
                $book->update([
                    'quantity' => $book->quantity + $product->quantity,
                ]);
            }
        }
        $item->delete();
        session()->flash('success', 'Successfully deleted!');
    }


    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($id, $status)
    {
        $getedItem = Purchase::findOrFail($id);
        if ($status == $getedItem->status) {
            return;
        }
        $getedItem->update([
            'status' => $status,
            'updated_user_id' => request()->user()->id,
        ]);

        $getedProducts = PurchaseItem::where('adjustment_id', $id)->get();

        if ($status == 1) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity + $product->quantity,
                ]);
            }
        } elseif ($status == 0) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity - $product->quantity,
                ]);
            }
        }

        session()->flash('success', 'Update Successfully!');
    }


    public function render()
    {

        $items = Adjustment::orderBy($this->sortBy, $this->sortDir)->orderBy('id', 'desc')
            ->paginate($this->perPage);



        return view('livewire.adjustment-table-data', [
            'items' => $items,
        ]);
    }
}
