<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Promotion;

use Image as ImageClass;

class PromotionCreate extends Component
{
    use WithFileUploads;

    public $image;

    public $name = null;
    public $link = null;
    public $short_description = null;


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
            'image' => 'required|image|max:2048',
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
        }

        $createdImage = Promotion::create($validated);

        // dd($createdImage);
        return redirect()->route('admin.promotions.index')->with('success', 'Successfully uploaded!');

        // session()->flash('message', 'Image successfully uploaded!');
    }

    public function render()
    {

        return view('livewire.promotion-create',);
    }
}
