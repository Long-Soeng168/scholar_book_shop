<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Order; 
use App\Models\OrderItem; 

use Image;

class OrderShow extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $order;
    public function mount($id) {
        $this->order = Order::findOrFail($id);
    }
    
   public function updateStatus($itemId, $status)
    {
        // Find the order by ID
        $item = Order::find($itemId);
        if ($item) {
            // Update the status
            $item->status = $status;
            $item->save();
        }
    
        // Set a flash message
        session()->flash('success', 'Status updated successfully.');
    
        // Redirect to a specific URL
       return redirect()->to('admin/orders/' . $itemId);

    }

    public function render()
    {
        $items = OrderItem::where('order_id', $this->order->id)
        ->paginate(10);

        return view('livewire.order-show', [
            'items' => $items,
            'order'=> $this->order,
        ]);
    }
}