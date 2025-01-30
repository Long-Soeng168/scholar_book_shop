<?php

namespace App\Livewire;

use App\Models\Author;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookSubCategory;
use App\Models\Publisher;
use Maatwebsite\Excel\Facades\Excel;

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

    public $author_id = null;
    public $publisher_id = null;
    public $category_id = null;
    public $sub_category_id = null;
    public $fromYear = null;
    public $toYear = null;



    public function setSortBy($newSortBy)
    {
        if ($this->sortBy == $newSortBy) {
            $newSortDir = ($this->sortDir == 'DESC') ? 'ASC' : 'DESC';
            $this->sortDir = $newSortDir;
        } else {
            $this->sortBy = $newSortBy;
        }
        $this->dispatch('livewire:updated');
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
        $this->dispatch('livewire:updated');
        session()->flash('success', 'Successfully deleted!');
    }


    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
        $this->dispatch('livewire:updated');
    }

    public function updateStatus($id, $status)
    {
        $getedItem = Book::findOrFail($id);
        $getedItem->update([
            'status' => $status,
            'last_edit_user_id' => request()->user()->id
        ]);
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
    }
    public function updateForSell($id, $status)
    {
        $getedItem = Book::findOrFail($id);
        $getedItem->update([
            'is_for_sell' => $status,
        ]);
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
    }

    public function updateIsFree($id, $status)
    {
        $getedItem = Book::findOrFail($id);
        $getedItem->update([
            'is_free' => $status,
        ]);
        $this->dispatch('livewire:updatedStatus');
        // session()->flash('success', 'Update Successfully!');
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function export()
    {
        return Excel::download(new class implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            public function collection()
            {
                // Fetch books with their related data
                return Book::with(['publisher', 'author', 'category', 'subCategory', 'created_by', 'updated_by'])
                    ->get()
                    ->map(function ($book) {
                        return [
                            'ID' => $book->id,
                            'Title' => $book->title,
                            'Cost' => $book->cost ?? 'N/A',
                            'Price' => $book->price ?? 'N/A',
                            'Discount' => $book->discount ?? 'N/A',
                            'Quantity' => $book->quantity ?? 'N/A',
                            'Pages' => $book->number_of_pages ?? 'N/A',
                            'Year' => $book->year ?? 'N/A',
                            'Language' => $book->language ?? 'N/A',
                            'Edition' => $book->edition ?? 'N/A',
                            'ISBN' => $book->isbn ?? 'N/A',
                            'Short Description' => $book->short_description ?? 'N/A',
                            'Image' => $book->image ?? 'N/A',
                            'File' => $book->file ?? 'N/A',
                            'Order Approved Count' => $book->order_approved ?? 'N/A',
                            'Status (1=public)' => $book->status ?? 'N/A',
                            'Publisher' => $book->publisher->name ?? 'N/A', // Related publisher name
                            'Author' => $book->author->name ?? 'N/A',       // Related author name
                            'Category' => $book->category->name ?? 'N/A',   // Related category name
                            'SubCategory' => $book->subCategory->name ?? 'N/A', // Related sub-category name
                            'Created By' => $book->created_by->name ?? 'N/A',   // User who created the book
                            'Updated By' => $book->updated_by->name ?? 'N/A',   // User who last updated the book
                            'Created At' => $book->created_at,
                        ];
                    });
            }

            public function headings(): array
            {
                // Define the column headings
                return [
                    'ID',
                    'Title',
                    'Cost',
                    'Price',
                    'Discount',
                    'Quantity',
                    'Pages',
                    'Year',
                    'Language',
                    'Edition',
                    'ISBN',
                    'Short Description',
                    'Image',
                    'File',
                    'Order Approved Count',
                    'Status (1=public)',
                    'Publisher',
                    'Author',
                    'Category',
                    'SubCategory',
                    'Created By',
                    'Updated By',
                    'Created At',
                ];
            }
        }, 'products.xlsx');
    }


    public function render()
    {

        $items = Book::with('publisher', 'author')
            ->where(function ($query) {
                $query->where('title', 'LIKE', "%$this->search%")
                    ->orWhere('internal_reference', 'LIKE', "%$this->search%")
                    ->orWhere('isbn', 'LIKE', "%$this->search%")
                    ->orWhereHas('publisher', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%");
                    })
                    ->orWhereHas('author', function ($q) {
                        $q->where('name', 'LIKE', "%$this->search%");
                    });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $categories = BookCategory::orderBy('name')->get();
        $subCategories = BookSubCategory::where('category_id', $this->category_id)->orderBy('name')->get();
        $authorss = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();

        return view('livewire.book-table-data', [
            'items' => $items,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'authorss' => $authorss,
            'publishers' => $publishers,
        ]);
    }
}
