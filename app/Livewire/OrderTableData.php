<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class OrderTableData extends Component
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
        $item = Link::findOrFail($id);
        $item->delete();

        session()->flash('success', 'Successfully deleted!');
    }

    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updateStatus($itemId, $status)
    {
        // Your logic here, e.g., updating a record in the database
        $item = Order::find($itemId);
        if ($item) {
            $item->status = $status;
            $item->save();
        }

        // Optionally, emit an event or set a flash message
        session()->flash('success', 'Status updated successfully.');
    }

    public $start_date = null;
    public $end_date = null;

    public function mount()
    {
        $this->end_date = Carbon::today()->toDateString();
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
                return Order::when($this->startDate, function ($query) {
                    $query->where('created_at', '>=', $this->startDate);
                })
                    ->when($this->endDate, function ($query) {
                        $query->where('created_at', '<=', $this->endDate);
                    })
                    ->get()
                    ->map(function ($invoice, $index) {
                        return [
                            'No' => $index + 1,
                            'Customer' => $invoice->name ?? 'N/A',
                            'Phone' => $invoice->phone ?? 'N/A',
                            'Note' => $invoice->note ?? 'N/A',
                            'Total' => $invoice->total ?? 'N/A',
                            'Order Date' => $invoice->created_at ?? 'N/A',
                            'Status' => $invoice->status == 1 ? 'Completed' : ($invoice->status == 0 ? 'In-Progress' : 'Rejected') ?? 'N/A',
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'No',
                    'Name',
                    'Phone',
                    'Note',
                    'Total',
                    'Order Date',
                ];
            }
        }, 'orders.xlsx');
    }

    public function render()
    {

        $items = Order::where(function ($query) {
            $query->where('name', 'LIKE', "%$this->search%")
                ->orWhere('phone', 'LIKE', "%$this->search%");
        })->when($this->start_date, function ($query) {
            $query->where('created_at', '>=', $this->start_date);
        })
            ->when($this->end_date, function ($query) {
                $query->where('created_at', '<=', $this->end_date);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.order-table-data', [
            'items' => $items,
        ]);
    }
}
