<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;

use Image;
use Maatwebsite\Excel\Facades\Excel;

class OrderShow extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $order;
    public function mount($id)
    {
        $this->order = Order::findOrFail($id);
    }

    public function updateStatus($itemId, $status)
    {
        // Validate inputs
        if (!in_array($status, [0, 1, -1], true)) {
            session()->flash('error', 'Invalid status value.');
            return redirect()->back();
        }

        // Find the order by ID
        $item = Order::find($itemId);
        if (!$item) {
            session()->flash('error', 'Order not found.');
            return redirect()->back();
        }

        // Update the order's status
        $item->status = $status;
        $item->save();

        // Update related order items if status is 1
        if ($status == 1) {
            $items = OrderItem::where('order_id', $itemId)->get();
            foreach ($items as $item) {
                Book::where('id', $item->product_id)->increment('order_approved', 1);
            }
        }

        // Set a flash message
        session()->flash('success', 'Status updated successfully.');

        // Redirect to the specific order page
        return redirect()->to('admin/orders/' . $itemId);
    }

    public function export()
    {
        $purchaseId = $this->order->id;
        $purchase = $this->order;

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
                return OrderItem::where('order_id', $this->purchaseId)
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
                        'Name',
                        'Phone',
                        'Note',
                        'Total',
                        'Order Date',
                        'Status',
                    ],
                    [
                        $this->purchase?->name ?? 'N/A',
                        $this->purchase?->phone ?? 'N/A',
                        $this->purchase?->note ?? 'N/A',
                        $this->purchase?->total ?? 'N/A',
                        $this->purchase?->created_at ?? 'N/A',
                        $this->purchase?->status == 1 ? 'Completed' : ($this->purchase?->status == 0 ? 'In-Progress' : 'Rejected'),
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
        }, 'order.xlsx');
    }


    public function render()
    {
        $items = OrderItem::where('order_id', $this->order->id)
            ->paginate(10);

        return view('livewire.order-show', [
            'items' => $items,
            'order' => $this->order,
        ]);
    }
}
