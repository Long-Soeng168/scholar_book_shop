<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\IsbnRequest;
use App\Models\Book;
use App\Models\IsbnRejectComment;

use Image;

class IsbnShow extends Component
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
        $this->item = IsbnRequest::findOrFail($id);

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

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048', // 2MB Max
        ]);

        session()->flash('success', 'Image successfully uploaded!');
    }

    public function approve()
    {

        $this->validate([
            'giveIsbn' => 'required|string|max:255',
        ]);

        if(!request()->user()->hasRole(['admin', 'super-admin'])){
            return;
        }

        $this->item->update([
            'isbn' => $this->giveIsbn,
            'status' => 1,
        ]);

        // Check if a Book with this id already exists
        if (!Book::where('isbn_id', $this->item->id)->exists()) {
            Book::create([
                'isbn_id' => $this->item->id,
                'title' => $this->item->title,
                'authors' => $this->item->authors,
                'number_of_pages' => $this->item->number_of_pages,
                'format' => $this->item->format,
                'price' => $this->item->price,
                'publication_date' => $this->item->publication_date,
                'edition' => $this->item->edition,
                'description' => $this->item->description,
                'language' => $this->item->language,
                'image' => $this->item->image,
                'isbn' => $this->item->isbn,
                'category_id' => $this->item->category_id,
                'sub_category_id' => $this->item->sub_category_id,
                'publisher_id' => $this->item->publisher_id,
                'publisher_name' => $this->item->publisher?->name,
            ]);
        } else {
            Book::where('isbn_id', $this->item->id)->update([
                'isbn' => $this->item->isbn,
            ]);
        }



        // dd($this->item);
        return redirect('/isbn_requests')->with('success', 'Successfully Approve!');

    }

    public function reject()
    {

        $this->validate([
            'reject_comment' => 'required|string|max:255',
        ]);

        $this->item->update([
            'status' => -1,
        ]);

        IsbnRejectComment::create([
            'isbn_id' => $this->item->id,
            'comment' => $this->reject_comment,
        ]);

        if (Book::where('isbn_id', $this->item->id)->exists()){
            Book::where('isbn_id', $this->item->id)->delete();
        }

        // dd($createdPublication);
        return redirect('/isbn_requests')->with('success', 'Successfully Reject!');

    }

    public function updatedIsbnAllocated(){
        $this->giveIsbn = $this->isbnAllocated;
    }

    public function render()
    {
        return view('livewire.isbn-show');
    }
}
