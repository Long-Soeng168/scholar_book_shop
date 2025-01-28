<?php

namespace App\Livewire;

use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class AdjustmentEdit extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 5;

    #[Url(history: true)]
    public $sortBy = 'id';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public $selectedProducts = [];
    public $adjustment_item;
    public $adjustment_date = null;

    public function mount($id)
    {
        $this->adjustment_item = Adjustment::findOrFail($id);
        // if(request()->user()->id !== $this->item->publisher_id && !request()->user()->hasRole(['super-admin', 'admin'])){
        //     return redirect('admin/books')->with('error', ['Only Onwer or Admin can update!']);
        // }

        $this->adjustment_date = $this->adjustment_item->adjustment_date ?? null;

        $adjustment_items = AdjustmentItem::where('adjustment_id', $id)->with('product')->get();
        foreach ($adjustment_items as $key => $value) {
            if (!collect($this->selectedProducts)->contains('id', $id)) {
                array_unshift($this->selectedProducts, [
                    'id' => $value->product_id,
                    'title' => $value->product?->title,
                    'quantity' => $value->quantity, // Default value
                    'action' => $value->action,
                ]);
            }
        }
    }

    public function handleSelectProduct($id)
    {
        $product = Book::find($id);

        if ($product) {
            // Add the product only if it's not already selected
            if (!collect($this->selectedProducts)->contains('id', $id)) {
                array_unshift($this->selectedProducts, [
                    'id' => $product->id,
                    'title' => $product->title,
                    'quantity' => 1, // Default value
                    'action' => 'add',
                ]);
            }
        }
        $this->dispatch('livewire:updated');
    }

    public function removeProduct($productId)
    {
        unset($this->selectedProducts[$productId]);
        $this->dispatch('livewire:updated');
    }

    public function updateProduct($productId, $field, $value)
    {
        foreach ($this->selectedProducts as $index => $product) {

            if ($product['id'] == $productId) {

                $this->selectedProducts[$index][$field] = $value; // Update the value
                // dd($this->selectedProducts[$index][$field]);

                // break;
            }
        }
        $this->dispatch('livewire:updated');

        // dd($this->selectedProducts);



        // session()->flash('success', 'Product updated successfully!');
    }


    public function save()
    {
        $this->validate([
            'selectedProducts' => 'required|array|min:1',
        ]);

        $this->adjustment_item->update([
            'updated_user_id' => request()->user()->id,
            'adjustment_date' => $this->adjustment_date,
        ]);

        $purchaseItems = AdjustmentItem::where('adjustment_id', $this->adjustment_item->id)->get();

        foreach ($purchaseItems as $key => $value) {
            $book = Book::find($value->product_id);
            if ($value->action == 'add') {
                $book->update([
                    'quantity' => $book->quantity - $value->quantity,
                ]);
            } elseif ($value->action == 'minus') {
                $book->update([
                    'quantity' => $book->quantity + $value->quantity,
                ]);
            }
            $value->delete();
        }

        // dd($purchase);

        foreach ($this->selectedProducts as $product) {
            AdjustmentItem::create([
                'adjustment_id' => $this->adjustment_item->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'action' => $product['action'],
            ]);

            $book = Book::find($product['id']);
            if ($product['action'] == 'add') {
                $book->update([
                    'quantity' => $book->quantity + $product['quantity'],
                ]);
            } elseif ($product['action'] == 'minus') {
                $book->update([
                    'quantity' => $book->quantity - $product['quantity'],
                ]);
            }
        }

        session()->flash('success', 'Adjustment updated successfully!');
        $this->reset(['selectedProducts']);
        return redirect('admin/adjustments');
    }




    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->dispatch('livewire:updated');
    }

    public function render()
    {
        // dd($selectedProducts);
        $items = Book::with('publisher', 'author', 'category')
            ->where(function ($query) {
                $query->where('title', 'LIKE', "%$this->search%")
                    ->orWhere('internal_reference', 'LIKE', "%$this->search%")
                    ->orWhere('isbn', 'LIKE', "%$this->search%")
                    ->orWhereHas('publisher', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%");
                    })
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%")->orWhere('name_kh', 'LIKE', "%$this->search%");
                    })
                    ->orWhereHas('author', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%");
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.adjustment-create', [
            'items' => $items,
        ]);
    }
}
