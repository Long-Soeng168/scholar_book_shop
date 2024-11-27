<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\IsbnRejectComment;

use Image;

class BookShow extends Component
{
    use WithFileUploads;

    public $item;
    public $image;

    public $giveIsbn;
    public $isbnAllocated = null;

    public $title = null;
    public $authors = null;
    public $number_of_pages = null;
    public $format = null;
    public $price = null;
    public $publication_date = null;
    public $edition = null;
    public $description = null;
    public $isbn_last_received = null;
    public $language = 'khmer';
    public $reject_comment = null;

    public function mount($id) {
        $this->item = Book::findOrFail($id);

        $this->giveIsbn = $this->item->status == 1 ? $this->item->isbn : null;
        $this->reject_comment = $this->item->status !== 1 ? $this->item->reject_comment : null;

        // $this->title = $this->item->title;
        // $this->authors = $this->item->authors;
        // $this->number_of_pages = $this->item->number_of_pages;
        // $this->format = $this->item->format;
        // $this->price = $this->item->price;
        // $this->publication_date = $this->item->publication_date;
        // $this->edition = $this->item->edition;
        // $this->description = $this->item->description;
        // $this->isbn_last_received = $this->item->isbn_last_received;
        // $this->language = $this->item->language;
    }

       public function updatedIsbnAllocated(){
        $this->giveIsbn = $this->isbnAllocated;
    }

    public function render()
    {
        return view('livewire.book-show');
    }
}
