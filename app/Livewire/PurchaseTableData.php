<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'purchase_date';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public $start_date = null;
    public $end_date = null;
    public function mount()
    {
        $this->end_date = Carbon::today()->toDateString();
    }

    public function setFilter($value)
    {
        $this->filter = $value;
        $this->resetPage();
    }

    public function setSortBy($newSortBy)
    {
        if ($this->sortBy == $newSortBy) {
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        } else {
            $this->sortBy = $newSortBy;
        }
    }
    public function delete($id)
    {
        $item = Purchase::findOrFail($id);

        $getedProducts = PurchaseItem::where('purchase_id', $id)->get();
        if ($item->status == 1) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity - $product->quantity,
                ]);
            }
        }

        $item->delete();
        session()->flash('success', 'Successfully deleted!');
    }


    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
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

        session()->flash('success', 'Update Successfully!');
    }

    public function export()
    {
        $startDate = $this->start_date; // Store start date
        $endDate = $this->end_date;     // Store end date

        return Excel::download(new class($startDate, $endDate) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $startDate;
            private $endDate;

            public function __construct($startDate, $endDate)
            {
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function collection()
            {
                // Fetch purchases with related data
                return Purchase::with(['supplier', 'created_by', 'updated_by'])
                    ->when($this->startDate, function ($query) {
                        $query->where('purchase_date', '>=', $this->startDate);
                    })
                    ->when($this->endDate, function ($query) {
                        $query->where('purchase_date', '<=', $this->endDate);
                    })
                    ->get()
                    ->map(function ($purchase) {
                        return [
                            'ID' => $purchase->id,
                            'Supplier' => $purchase->supplier->name ?? 'N/A', // Related supplier name
                            'Purchase Date' => $purchase->purchase_date ?? 'N/A',
                            'Total Amount' => number_format($purchase->total_amount, 2) ?? 'N/A', // Format amount
                            'Status' => $purchase->status == 1 ? 'Received' : 'Not Received',
                            'Created By' => $purchase->created_by->name ?? 'N/A', // User who created the purchase
                            'Updated By' => $purchase->updated_by->name ?? 'N/A', // User who last updated the purchase
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'ID',
                    'Supplier',
                    'Purchase Date',
                    'Total Amount',
                    'Status',
                    'Created By',
                    'Updated By',
                ];
            }
        }, 'purchases.xlsx');
    }




    public function render()
    {

        $items = Purchase::orderBy($this->sortBy, $this->sortDir)
            ->when($this->start_date, function ($query) {
                $query->where('purchase_date', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
            $query->where('purchase_date', '<=', $this->end_date);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);



        return view('livewire.purchase-table-data', [
            'items' => $items,
        ]);
    }
}
