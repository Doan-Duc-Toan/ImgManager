<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use App\Models\Post;
use Livewire\WithPagination;

class ImageUpload extends Component
{
    use WithFileUploads;
    use WithPagination;
    #[Rule('image|max:2048')] // 2MB Max
    public $image;
    #[Rule('required|min:3')]
    public $title;
    public $postId;
    public $oldImage;
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->title = $post->title;
        $this->oldImage = $post->image;

        $this->openModal();
    }
    public function update()
    {
        $this->validate([
            'title' => 'required|min:3',
        ]);
        $post = Post::findOrFail($this->postId);
        $photo = $post->image;
        if ($this->image) {
            Storage::delete($post->image);
            $photo = $this->image->store('public/photos');
        } else {
            $photo = $post->image;
        }

        $post->update([
            'title' => $this->title,
            'image' => $photo,
        ]);
        $this->postId = '';

        session()->flash('success', 'Image updated successfully.');
        $this->closeModal();
        $this->reset('title', 'image', 'postId');
    }
    public function delete($id)
    {
        $singleImage = Post::findOrFail($id);
        Storage::delete($singleImage->image);
        $singleImage->delete();
        session()->flash('success', 'Image deleted Successfully!!');
        $this->reset('title', 'image');
    }
    public function store()
    {
        $this->validate();
        Post::create([
            'title' => $this->title,
            'image' => $this->image->store('public/photos')
        ]);
        session()->flash('success', 'Image uploaded successfully.');
        $this->reset('title', 'image');
        $this->closeModal();
    }
    public $isOpen = 0;
    public function create()
    {
        $this->reset('title', 'image','oldImage');
        $this->reset('postId');
        $this->openModal();
    }
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;

    }

    public function render()
    {
        return view('livewire.image-upload', [
            'posts' => Post::paginate(5)
        ]);
    }
}
