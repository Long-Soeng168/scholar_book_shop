<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Image;

class SaleShow extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $purchase;
    public $update_status;
    public function mount($id)
    {
        $this->purchase = Invoice::findOrFail($id);
    }

    public function updateStatus($id, $status)
    {
        $getedItem = Invoice::findOrFail($id);
        if ($status == $getedItem->status) {
            return;
        }
        $getedItem->update([
            'status' => $status,
            'updated_user_id' => request()->user()->id,
        ]);

        $getedProducts = InvoiceItem::where('invoice_id', $id)->get();

        if ($status == 1) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity - $product->quantity,
                ]);
            }
        } elseif ($status == 0) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity + $product->quantity,
                ]);
            }
        }
        $this->update_status = $status;
        session()->flash('success', 'Update Successfully!');
        return redirect()->to('admin/sales/' . $this->purchase->id);
    }


    public function render()
    {
        $items = InvoiceItem::where('invoice_id', $this->purchase->id)
            ->paginate(10);

        return view('livewire.sale-show', [
            'items' => $items,
            'order' => $this->purchase,
        ]);
    }
}
