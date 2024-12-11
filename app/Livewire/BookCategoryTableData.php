<?php

namespace App\Livewire;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;


use App\Models\BookCategory as Category;
use Image;

class BookCategoryTableData extends Component
{
    use WithPagination;
    use WithFileUploads;


    public $image;


    #[Url(history: true)]
    public $search = '';

    #[Url(history: true)]
    public $perPage = 10;

    #[Url(history: true)]
    public $filter = 0;

    #[Url(history: true)]
    public $sortBy = 'created_at';

    #[Url(history: true)]
    public $sortDir = 'DESC';

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048', // 2MB Max
        ]);

        session()->flash('success', 'Image successfully uploaded!');
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

    // ResetPage when updated search
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();

        session()->flash('success', 'Category successfully deleted!');
    }

    // ==========Add New Category============
    public $newDdc = null;
    public $newName = null;
    public $newName_kh = null;

    public function save()
    {
        try {
            $validated = $this->validate([
                'newName' => 'required|string|max:255|unique:categories,name',
                'newName_kh' => 'required|string|max:255',
                'newDdc' => 'nullable|string|max:255',
            ]);

            if (!empty($this->image)) {
                // $filename = time() . '_' . $this->image->getClientOriginalName();
                $filename = time() . str()->random(10) . '.' . $this->image->getClientOriginalExtension();

                $image_path = public_path('assets/images/categories/' . $filename);
                $imageUpload = Image::make($this->image->getRealPath())->save($image_path);
                $validated['image'] = $filename;
            }

            Category::create([
                'ddc' => $this->newDdc,
                'name' => $this->newName,
                'name_kh'=> $this->newName_kh,
                'image' => $filename ?? '',
            ]);

            session()->flash('success', 'Add New Category successfully!');

            $this->reset(['newName', 'newName_kh', 'ddc']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public $editId = null;
    public $ddc;
    public $name;
    public $name_kh;

    public function setEdit($id)
    {
        $category = Category::find($id);
        $this->editId = $id;
        $this->ddc = $category->ddc;
        $this->name = $category->name;
        $this->name_kh = $category->name_kh;
    }

    public function cancelUpdate()
    {
        $this->editId = null;
        $this->ddc = null;
        $this->name = null;
        $this->name_kh = null;
        $this->gender = null;
    }

    public function update($id)
    {
        try {
            $validated = $this->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id,
                'name_kh' => 'required|string|max:255',
                'ddc' => 'nullable|string|max:255',
            ]);

            if (!empty($this->image)) {
                // $filename = time() . '_' . $this->image->getClientOriginalName();
                $filename = time() . str()->random(10) . '.' . $this->image->getClientOriginalExtension();

                $image_path = public_path('assets/images/categories/' . $filename);
                $imageUpload = Image::make($this->image->getRealPath())->save($image_path);
                $validated['image'] = $filename;
            }


            $category = Category::find($id);
            $category->update($validated);

            session()->flash('success', 'Category successfully edited!');

            $this->reset(['name', 'name_kh', 'editId', 'ddc']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', $e->validator->errors()->all());
        }
    }

    public function render()
    {

        $items = Category::where(function ($query) {
            $query->where('name', 'LIKE', "%$this->search%")
                ->orWhere('name_kh', 'LIKE', "%$this->search%");
        })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.book-category-table-data', [
            'items' => $items,
        ]);
    }
}
