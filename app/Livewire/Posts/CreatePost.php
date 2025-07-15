<?php

namespace App\Livewire\Posts;

use App\Actions\Post\CreatePost as PostCreatePost;
use App\Http\Requests\CreatePostRequest;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class CreatePost extends Component
{
    use WithFileUploads;

    public $title = '';
    public $content = '';
    public $status = 'draft';
    public $image;

    public function rules()
    {
        return (new CreatePostRequest())->rules();
    }

    public function save(PostCreatePost $create)
    {
        try {
            $validated = $this->validate();

            if ($this->image) {
                $validated['image'] = $this->image->store('posts', 'public');
            }

            $create->run($validated);

            session()->flash('success', 'Post created successfully!');

            $this->reset();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.posts.create-post');
    }
}
