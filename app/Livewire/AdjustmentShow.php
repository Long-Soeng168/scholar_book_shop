<?php

namespace App\Livewire;

use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;

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
                return AdjustmentItem::where('adjustment_id', $this->purchaseId)
                    ->get()
                    ->map(function ($item, $index) {
                        return [
                            'No' => $index + 1,
                            'Title' => $item->product?->title,
                            'ISBN' => $item->product?->isbn,
                            'Quantity' => $item->quantity,
                            'Action' => $item->action == 'minus' ? 'Minus (-)' : 'Add (+)',
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    [
                        'Adjustment Date',
                        'Created By',
                        'Updated By',
                    ],
                    [
                        $this->purchase?->adjustment_date ?? 'N/A',
                        $this->purchase?->created_by?->name ?? 'N/A',
                        $this->purchase?->updated_by?->name ?? 'N/A',
                    ],
                    [],
                    [
                        'No',
                        'Title',
                        'ISBN',
                        'Quantity',
                        'Action',
                    ]
                ];
            }
        }, 'adjustment.xlsx');
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
