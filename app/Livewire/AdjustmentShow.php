<?php

namespace App\Livewire;

use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;

class AdjustmentShow extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $purchase;
    public $update_status;
    public function mount($id)
    {
        $this->purchase = Adjustment::findOrFail($id);
    }

    public function updateStatus($id, $status)
    {
        $getedItem = Adjustment::findOrFail($id);
        if ($status == $getedItem->status) {
            return;
        }
        $getedItem->update([
            'status' => $status,
            'updated_user_id' => request()->user()->id,
        ]);

        $getedProducts = AdjustmentItem::where('adjustment_id', $id)->get();

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
        $this->update_status = $status;
        session()->flash('success', 'Update Successfully!');
        return redirect()->to('admin/purchases/' . $this->purchase->id);
    }


    public function render()
    {
        $items = AdjustmentItem::where('adjustment_id', $this->purchase->id)
            ->paginate(10);

        return view('livewire.adjustment-show', [
            'items' => $items,
            'order' => $this->purchase,
        ]);
    }
}
