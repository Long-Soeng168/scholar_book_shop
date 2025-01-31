<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Image;
use Maatwebsite\Excel\Facades\Excel;

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
                return InvoiceItem::where('invoice_id', $this->purchaseId)
                    ->get()
                    ->map(function ($item, $index) {
                        return [
                            'No' => $index + 1,
                            'Title' => $item->product?->title,
                            'ISBN' => $item->product?->isbn,
                            'Price' => $item->price,
                            'Discount' => $item->discount,
                            'Quantity' => $item->quantity,
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    [
                        'Invoice ID',
                        'Sub Total',
                        'Discount',
                        'Discount Type',
                        'Total',
                        'Customer',
                        'Pay By',
                        'Purchase Date',
                        'Sale By',
                        'Updated By',
                        'Status',
                    ],
                    [
                        $this->purchase?->id ?? 'N/A',
                        $this->purchase?->subtotal ?? 'N/A',
                        $this->purchase?->discount ?? 'N/A',
                        $this->purchase?->discountType == 'percentage' ? ' %' : ' $',
                        $this->purchase?->total ?? 'N/A',
                        $this->purchase?->customer?->name ?? 'N/A',
                        $this->purchase?->payment?->name ?? 'N/A',
                        $this->purchase?->created_at ?? 'N/A',
                        $this->purchase?->user?->name ?? 'N/A',
                        $this->purchase?->updated_by?->name ?? 'N/A',
                        $this->purchase?->status == 1 ? 'Paid' : 'Hold',
                    ],
                    [],
                    [
                        'No',
                        'Title',
                        'ISBN',
                        'Unit Price',
                        'Discount (%)',
                        'Quantity',
                    ]
                ];
            }
        }, 'sale.xlsx');
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
