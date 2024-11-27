<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;

class BookTableData extends Component
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
        $item = Book::findOrFail($id);

        // Check and delete associated image and thumbnail
        if (!empty($item->image)) {
            $imagePath = public_path('assets/images/isbn/' . $item->image);
            $thumbPath = public_path('assets/images/isbn/thumb/' . $item->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }
        }

        // Delete the book record
        $item->delete();

        // Flash success message
        session()->flash('success', 'Successfully deleted!');
    }


    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $items = Book::where('title', 'LIKE', "%$this->search%")
            ->when(!request()->user()->hasRole(['admin', 'super-admin']), function ($query) {
                $query->where('publisher_id', request()->user()->id);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);



        return view('livewire.book-table-data', [
            'items' => $items,
        ]);
    }
}
