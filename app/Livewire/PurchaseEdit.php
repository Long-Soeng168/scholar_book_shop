<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Image;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PurchaseEdit extends Component
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

    public $purchase_item;
    public $product_id = [];
    public $supplier_id = null;
    public $status = 1;
    public $init_status = 1;
    public $selectedProducts = [];
    public $purchase_date = null;
    public $total_amount = 0;

    public function mount($id)
    {
        $this->purchase_item = Purchase::findOrFail($id);
        // if(request()->user()->id !== $this->item->publisher_id && !request()->user()->hasRole(['super-admin', 'admin'])){
        //     return redirect('admin/books')->with('error', ['Only Onwer or Admin can update!']);
        // }

        $this->purchase_date = $this->purchase_item->purchase_date ?? null;
        $this->supplier_id = $this->purchase_item->supplier_id ?? null;
        $this->status = $this->purchase_item->status ?? 1;
        $this->init_status = $this->purchase_item->status ?? 0;

        $purchase_items = PurchaseItem::where('purchase_id', $id)->with('product')->get();
        foreach ($purchase_items as $key => $value) {
            if (!collect($this->selectedProducts)->contains('id', $id)) {
                array_unshift($this->selectedProducts, [
                    'id' => $value->product_id,
                    'title' => $value->product?->title,
                    'quantity' => $value->quantity, // Default value
                    'price' => $value->price > 0 ? $value->price : 0,
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
                    'price' => $product->cost > 0 ? $product->cost : 0,
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
    public function updatedSearch()
    {
        $this->resetPage();
        $this->dispatch('livewire:updated');
    }


    public function save()
    {
        $this->validate([
            'selectedProducts' => 'required|array|min:1',
        ]);

        foreach ($this->selectedProducts as $index => $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $this->total_amount += $subtotal;
        }

        $this->purchase_item->update([
            'supplier_id' => $this->supplier_id,
            'status' => $this->status,
            'updated_user_id' => request()->user()->id,
            'purchase_date' => $this->purchase_date,
            'total_amount' => $this->total_amount,
        ]);

        $purchaseItems = PurchaseItem::where('purchase_id', $this->purchase_item->id)->get();

        foreach ($purchaseItems as $key => $value) {
            if ($this->init_status == 1) {
                $book = Book::find($value->product_id);
                $book->update([
                    'quantity' => $book->quantity - $value->quantity,
                ]);
            }
            $value->delete();
        }

        // dd($purchase);

        foreach ($this->selectedProducts as $product) {
            PurchaseItem::create([
                'purchase_id' => $this->purchase_item->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['price'] * $product['quantity'],
            ]);

            if ($this->status == 1) {
                $book = Book::find($product['id']);
                $book->update([
                    'quantity' => $book->quantity + $product['quantity'],
                ]);
            }
        }

        session()->flash('success', 'Purchase saved successfully!');
        $this->reset(['selectedProducts']);
        return redirect('/admin/purchases');
    }




    public function updated()
    {
        $this->dispatch('livewire:updated');
    }


    public function render()
    {
        // dd($selectedProducts);

        $suppliers = Supplier::orderBy('name')->get();

        $items = Book::with('publisher', 'author')
            ->where(function ($query) {
                $query->where('title', 'LIKE', "%$this->search%")
                    ->orWhere('internal_reference', 'LIKE', "%$this->search%")
                    ->orWhere('isbn', 'LIKE', "%$this->search%")
                    ->orWhereHas('publisher', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%");
                    })
                    ->orWhereHas('author', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%");
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.purchase-create', [
            'items' => $items,
            'suppliers' => $suppliers,
        ]);
    }
}
