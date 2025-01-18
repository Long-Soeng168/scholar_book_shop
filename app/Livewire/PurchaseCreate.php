<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookSubCategory;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Image;

class PurchaseCreate extends Component
{
    use WithFileUploads;
    public $product_id = [];
    public $selectedProducts = [];

    public function handleSelectProduct($id)
    {
        $product = Book::find($id);

        if ($product) {
            // Add the product only if it's not already selected
            if (!collect($this->selectedProducts)->contains('id', $id)) {
                $this->selectedProducts[] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'quantity' => 1, // Default value
                    'price' => $product->price ?? 0,
                ];
            }
        }
    }

    public function removeProduct($productId)
    {
        unset($this->selectedProducts[$productId]);
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
        // dd($this->selectedProducts);



        // session()->flash('success', 'Product updated successfully!');
    }


    public function save()
    {
        $this->validate([
            'selectedProducts' => 'required|array|min:1',
        ]);

        $purchase = Purchase::create([
            'supplier_id' => null,
            'status' => 0
        ]);

        foreach ($this->selectedProducts as $product) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        session()->flash('success', 'Purchase saved successfully!');
        $this->reset(['selectedProducts']);
    }




    public function updated()
    {
        $this->dispatch('livewire:updated');
    }


    public function render()
    {
        $products = Book::get();
        // dd($selectedProducts);

        $publishers = Publisher::orderBy('name')->get();

        return view('livewire.purchase-create', [
            'products' => $products,
            'publishers' => $publishers,
        ]);
    }
}
