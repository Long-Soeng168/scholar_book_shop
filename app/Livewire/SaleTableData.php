<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class SaleTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'id';

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
        $item = Invoice::findOrFail($id);

        $getedProducts = InvoiceItem::where('invoice_id', $id)->get();
        if ($item->status == 1) {
            foreach ($getedProducts as $product) {
                $book = Book::find($product->product_id);
                $book->update([
                    'quantity' => $book->quantity + $product->quantity,
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
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
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
                // Fetch invoices with related data
                return Invoice::with(['customer', 'user', 'updated_by', 'payment'])
                    ->when($this->startDate, function ($query) {
                        $query->where('created_at', '>=', $this->startDate);
                    })
                    ->when($this->endDate, function ($query) {
                        $query->where('created_at', '<=', $this->endDate);
                    })
                    ->where('status', 1)
                    ->get()
                    ->map(function ($invoice, $index) {
                        return [
                            'No' => $index + 1,
                            'ID' => $invoice->id,
                            'Customer' => $invoice->customer->name ?? 'N/A', // Related customer name
                            'Subtotal' => number_format($invoice->subtotal, 2) ?? 'N/A', // Format subtotal
                            'Discount' => $invoice->discountType === 'percentage'
                                ? ($invoice->discount . '%')
                                : ('$' . number_format($invoice->discount, 2)),
                            'Total' => number_format($invoice->total, 2) ?? 'N/A', // Format total
                            'Payment Methode' => $invoice->payment->name ?? 'N/A', // Related payment type
                            'Created By' => $invoice->user->name ?? 'N/A', // User who created the invoice
                            'Created At' => $invoice->created_at->format('Y-m-d H:i:s'), // Format date
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Invoice ID',
                    'Customer',
                    'Subtotal',
                    'Discount',
                    'Total',
                    'Payment Methode',
                    'Sale By',
                    'Created At',
                ];
            }
        }, 'sales.xlsx');
    }


    public function render()
    {

        $items = Invoice::when($this->search, function ($query) {
            $query->where('id', 'LIKE', "%$this->search%");
        })
            ->when($this->start_date, function ($query) {
                $query->where('created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                $query->where('created_at', '<=', $this->end_date);
            })
            ->orderBy($this->sortBy, $this->sortDir)->orderBy('id', 'desc')
            ->paginate($this->perPage);



        return view('livewire.sale-table-data', [
            'items' => $items,
        ]);
    }
}
