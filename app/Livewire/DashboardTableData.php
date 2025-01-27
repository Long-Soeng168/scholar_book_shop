<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Book;
use App\Models\Customer;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Link;
use App\Models\News;
use App\Models\Publisher;
use App\Models\Supplier;

class DashboardTableData extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $sortBy = 'order_index';

    #[Url(history: true)]
    public $sortDir = 'ASC';

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

    public function render()
    {

        $items = Book::count();
        $items_with_file = Book::where('file', '!=', null)->count();
        $authors = Author::count();
        $publishers = Publisher::count();
        $customers = Customer::count();
        $suppliers = Supplier::count();
        $news = News::count();

        $counts = [
            'items' => $items ?? 0,
            'items_with_file' => $items_with_file ?? 0,
            'authors' => $authors ?? 0,
            'publishers' => $publishers ?? 0,
            'customers' => $customers ?? 0,
            'suppliers' => $suppliers ?? 0,
            'news' => $news,
        ];

        return view('livewire.dashboard-table-data', [
            'counts' => $counts,
        ]);
    }
}
