<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseShow extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $purchase;
    public $update_status;
    public function mount($id)
    {
        $this->purchase = Purchase::findOrFail($id);
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

        $getedProducts = PurchaseItem::where('purchase_id', $id)->get();

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

    public function export()
    {
        $purchaseId = $this->purchase->id;
        $purchase = $this->purchase;

        return Excel::download(new class($purchaseId, $purchase) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $purchaseId;
            private $purchase;

            public function __construct($purchaseId, $purchase)
            {
                $this->purchaseId = $purchaseId;
                $this->purchase = $purchase;
            }

            public function collection()
            {
                // Fetch purchases with related data
                return PurchaseItem::where('purchase_id', $this->purchaseId)
                    ->get()
                    ->map(function ($item, $index) {
                        return [
                            'No' => $index + 1,
                            'Title' => $item->product?->title,
                            'ISBN' => $item->product?->isbn,
                            'Price' => $item->price,
                            'Quantity' => $item->quantity,
                            'SubTotal' => $item->subtotal,
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    [
                        'Supplier',
                        'Total',
                        'Purchase Date',
                        'Created By',
                        'Updated By',
                        'Status',
                    ],
                    [
                        $this->purchase?->supplier?->name ?? 'N/A',
                        $this->purchase?->total_amount ?? 'N/A',
                        $this->purchase?->purchase_date ?? 'N/A',
                        $this->purchase?->created_by?->name ?? 'N/A',
                        $this->purchase?->updated_by?->name ?? 'N/A',
                        $this->purchase?->status == 1 ? 'Recieved' : 'Not-Recieved',
                    ],
                    [],
                    [
                        'No',
                        'Title',
                        'ISBN',
                        'Unit Cost',
                        'Quantity',
                        'SubTotal',
                    ]
                ];
            }
        }, 'purchase.xlsx');
    }


    public function render()
    {
        $items = PurchaseItem::where('purchase_id', $this->purchase->id)
            ->paginate(10);

        return view('livewire.purchase-show', [
            'items' => $items,
            'order' => $this->purchase,
        ]);
    }
}
