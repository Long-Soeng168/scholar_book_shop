<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;

use Image;

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
        if (!in_array($status, [0, 1], true)) {
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
