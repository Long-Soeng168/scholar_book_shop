<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Promotion;

use Image as ImageClass;

class PromotionEdit extends Component
{
    use WithFileUploads;

    public $item;
    public $image;

    public $name = null;
    public $link = null;
    public $short_description = null;

    public function mount($id)
    {
        $this->item = Promotion::findOrFail($id);

        $this->name = $this->item->name;
        $this->link = $this->item->link;
        $this->short_description = $this->item->short_description;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048', // 2MB Max
        ]);

        session()->flash('success', 'Image successfully uploaded!');
    }

    public function updated()
    {
        $this->dispatch('livewire:updated');
    }


    public function save()
    {
        $this->dispatch('livewire:updated');
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'short_description' => 'nullable',
        ]);

        foreach ($validated as $key => $value) {
            if (is_null($value) || $value === '') {
                unset($validated[$key]);
            }
        }

        // dd($validated);

        if(!empty($this->image)){
            // $filename = time() . '_' . $this->image->getClientOriginalName();
            $filename = time() . str()->random(10) . '.' . $this->image->getClientOriginalExtension();

            $promotions_path = public_path('assets/images/promotions/'.$filename);
            $promotions_thumb_path = public_path('assets/images/promotions/thumb/'.$filename);
            $imageUpload = ImageClass::make($this->image->getRealPath())->save($promotions_path);
            $imageUpload->resize(400,null,function($resize){
                $resize->aspectRatio();
            })->save($promotions_thumb_path);
            $validated['image'] = $filename;

            if (!empty($this->oldImage)) {
                $oldImagePath = public_path('assets/images/promotions/' . $this->oldImage);
                $oldThumbPath = public_path('assets/images/promotions/thumb/' . $this->oldImage);

                // Delete the old image and thumbnail if they exist
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
        }

        $createdImage = $this->item->update($validated);

        // dd($createdImage);
        return redirect()->route('admin.promotions.index')->with('success', 'Successfully uploaded!');

        // session()->flash('message', 'Image successfully uploaded!');
    }

    public function render()
    {

        return view('livewire.promotion-edit',);
    }
}
