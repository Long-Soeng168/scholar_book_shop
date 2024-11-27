<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\IsbnRequest;
use App\Models\BookCategory;
use App\Models\BookSubCategory;

use Image;

class IsbnEdit extends Component
{
    use WithFileUploads;

    public $item;
    public $image;

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

    public $category_id = null;
    public $sub_category_id = null;

    public function updatedCategory_id()
    {
        $this->sub_category_id = null;
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }

    public function mount($id) {
        $this->item = IsbnRequest::findOrFail($id);
        if($this->item->status == 1) {
            return redirect('/isbn_requests')->with('error', ['Cannot Edit Approved Item!']);
        }

        if(request()->user()->id !== $this->item->publisher_id && !request()->user()->hasRole(['super-admin', 'admin'])){
            return redirect('isbn_requests')->with('error', ['Only Onwer or Admin can update!']);
        }



        $this->giveIsbn = $this->item->status == 1 ? $this->item->isbn : null;
        $this->reject_comment = $this->item->status !== 1 ? $this->item->reject_comment : null;

        $this->title = $this->item->title;
        $this->authors = $this->item->authors;
        $this->number_of_pages = $this->item->number_of_pages;
        $this->format = $this->item->format;
        $this->price = $this->item->price;
        $this->publication_date = $this->item->publication_date;
        $this->edition = $this->item->edition;
        $this->description = $this->item->description;
        $this->isbn_last_received = $this->item->isbn_last_received;
        $this->language = $this->item->language;
        $this->category_id = $this->item->category_id;
        $this->sub_category_id = $this->item->sub_category_id;
    }



    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048', // 2MB Max
        ]);

        session()->flash('success', 'Image successfully uploaded!');
    }

    public function save()
    {

        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string|max:255',
            'number_of_pages' => 'required|int',
            'format' => 'required|string|max:255',
            'price' => 'required|int',
            'publication_date' => 'required|date',
            'edition' => 'required|string|max:255',
            'description' => 'required|string',
            'language' => 'required|string|max:255',
            'isbn_last_received' => 'nullable|string|max:255',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
        ]);

        // dd($validated);
        // $validated['publisher_id'] = request()->user()->id;
        $validated['status'] = 0;

        foreach ($validated as $key => $value) {
            if (is_null($value) || $value === '') {
                $validated[$key] == null;
            }
        }

        if(!empty($this->image)){
            // $filename = time() . '_' . $this->image->getClientOriginalName();
            $filename = time() . str()->random(10) . '.' . $this->image->getClientOriginalExtension();

            $image_path = public_path('assets/images/isbn/'.$filename);
            $image_thumb_path = public_path('assets/images/isbn/thumb/'.$filename);
            $imageUpload = Image::make($this->image->getRealPath())->save($image_path);
            $imageUpload->resize(600,null,function($resize){
                $resize->aspectRatio();
            })->save($image_thumb_path);
            $validated['image'] = $filename;
        }

        $this->item->update($validated);

        // dd($createdPublication);
        return redirect('/isbn_requests')->with('success', 'Successfully Created!');

        session()->flash('success', 'Successfully Submit!');
    }

    public function render()
    {
        // dd($allKeywords);
        // dump($this->selectedallKeywords);
        $categories = BookCategory::orderBy('name')->get();
        $subCategories = BookSubCategory::where('category_id', $this->category_id)->orderBy('name')->get();

        return view('livewire.isbn-edit', compact('categories', 'subCategories'));
    }
}
