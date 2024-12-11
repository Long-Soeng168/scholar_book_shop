<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookSubCategory;

use Image;

class BookEdit extends Component
{
    use WithFileUploads;

    public $item;
    public $image;

    public $file;


    public $title = null;
    public $authors = null;
    public $author_id = null;
    public $publisher_id = null;
    public $number_of_pages = null;
    public $format = null;
    public $price = null;
    public $discount = null;
    public $publication_date = null;
    public $year = null;
    public $edition = null;
    public $short_description = null;
    public $description = null;
    public $isbn = null;
    public $tsin = null;
    public $language = 'khmer';

    public $category_id = null;
    public $sub_category_id = null;

    public function mount($id) {
        $this->item = Book::findOrFail($id);
        // if(request()->user()->id !== $this->item->publisher_id && !request()->user()->hasRole(['super-admin', 'admin'])){
        //     return redirect('admin/books')->with('error', ['Only Onwer or Admin can update!']);
        // }

        $this->title = $this->item->title;
        $this->authors = $this->item->authors;
        $this->number_of_pages = $this->item->number_of_pages;
        $this->format = $this->item->format;
        $this->price = $this->item->price;
        $this->publication_date = $this->item->publication_date;
        $this->edition = $this->item->edition;
        $this->description = $this->item->description;
        $this->isbn = $this->item->isbn;
        $this->tsin = $this->item->tsin;
        $this->language = $this->item->language;
        $this->category_id = $this->item->category_id;
        $this->sub_category_id = $this->item->sub_category_id;
        $this->short_description = $this->item->short_description;
        $this->discount = $this->item->discount;
        $this->author_id = $this->item->author_id;
        $this->publisher_id = $this->item->publisher_id;
        $this->year = $this->item->year;
    }


    public function updatedCategory_id()
    {
        $this->sub_category_id = null;
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }



    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048', // 2MB Max
        ]);

        session()->flash('success', 'Image successfully uploaded!');
    }

    public $newAuthorName = null;
    public $newAuthorGender = null;

    public function saveNewAuthor()
    {
        try {
            $validated = $this->validate([
                'newAuthorName' => 'required|string|max:255|unique:authors,name',
            ]);

            Author::create([
                'name' => $this->newAuthorName,
                'gender' => $this->newAuthorGender,
            ]);

            session()->flash('success', 'Add New Author successfully!');

            $this->reset(['newAuthorName', 'newAuthorGender']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public $newPublisherName = null;
    public $newPublisherGender = null;

    public function saveNewPublisher()
    {
        try {
            $this->validate([
                'newPublisherName' => 'required|string|max:255|unique:publishers,name',
                // Add validation rules for 'newPublisherGender' if needed
            ]);

            Publisher::create([
                'name' => $this->newPublisherName,
                'gender' => $this->newPublisherGender,
            ]);

            session()->flash('success', 'Add New Publisher successfully!');

            $this->reset(['newPublisherName', 'newPublisherGender']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public function save()
    {

        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'price' => 'required',
            'discount' => 'nullable',
            'language' => 'required|string|max:255',
            'authors' => 'nullable|string|max:255',
            'number_of_pages' => 'nullable|int',
            'format' => 'nullable|string|max:255',
            'year' => 'nullable',
            'edition' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:255',
            'tsin' => 'nullable|string|max:255',
            'author_id' => 'nullable',
            'publisher_id' => 'nullable',
            'category_id' => 'nullable',
            'sub_category_id' => 'nullable',
        ]);

        // dd($validated);
        $validated['publisher_id'] = request()->user()->id;

        foreach ($validated as $key => $value) {
            if (is_null($value) || $value === '') {
                $validated[$key] == null;
            }
        }

        if (!empty($this->image)) {
            // $filename = time() . '_' . $this->image->getClientOriginalName();
            $filename = time() . str()->random(10) . '.' . $this->image->getClientOriginalExtension();

            $image_path = public_path('assets/images/isbn/' . $filename);
            $image_thumb_path = public_path('assets/images/isbn/thumb/' . $filename);
            $imageUpload = Image::make($this->image->getRealPath())->save($image_path);
            $imageUpload->resize(600, null, function ($resize) {
                $resize->aspectRatio();
            })->save($image_thumb_path);
            $validated['image'] = $filename;

            if (!empty($this->item->image)) {
                $oldImagePath = public_path('assets/images/isbn/' . $this->item->image);
                $oldThumbPath = public_path('assets/images/isbn/thumb/' . $this->item->image);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
        }

        if (!empty($this->file)) {
            // $filename = time() . '_' . $this->file->getClientOriginalName();
            $filename = time() . str()->random(10) . '.' . $this->file->getClientOriginalExtension();
            $this->file->storeAs('books', $filename, 'publicForPdf');
            $validated['file'] = $filename;

            if (!empty($this->item->file)) {
                $filePath = public_path('assets/pdf/books/' . $this->item->file);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }

            }
        }

        $createdPublication = $this->item->update($validated);

        // dd($createdPublication);
        return redirect('/admin/books')->with('success', 'Successfully Created!');

        // session()->flash('success', 'Successfully Submit!');
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'file|max:51200', // 2MB Max
        ]);

        session()->flash('success', 'file successfully uploaded!');
    }

    public function render()
    {
        // dd($allKeywords);
        // dump($this->selectedallKeywords);
        $categories = BookCategory::orderBy('name')->get();
        $subCategories = BookSubCategory::where('category_id', $this->category_id)->orderBy('name')->get();
        $authorss = Author::orderBy('name')->get();
        $publishers = Publisher::orderBy('name')->get();

        return view('livewire.book-create', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'authorss' => $authorss,
            'publishers' => $publishers,
        ]);
    }
}
