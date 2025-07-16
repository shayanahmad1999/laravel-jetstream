<?php

namespace App\Livewire\Posts;

use App\Actions\Post\UpdatePost;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class EditPost extends Component
{
    use WithFileUploads;

    public Post $post;
    public $title = '';
    public $content = '';
    public $status = '';
    public $image;

    public function mount($slug)
    {
        $this->post = Post::where('slug', $slug)->firstOrFail();

        $this->title = $this->post->title;
        $this->content = $this->post->content;
        $this->status = $this->post->status;
    }

    public function rules()
    {
        return (new CreatePostRequest())->rules();
    }

    public function update(UpdatePost $update)
    {
        try {
            $validated = $this->validate();

            if ($this->image) {
                $validated['image'] = $this->image->store('posts', 'public');
            } else {
                $validated['image'] = $this->post->image;
            }

            $validated['slug'] = $this->post->slug;
            $update->run($validated);

            session()->flash('success', 'Post updated successfully!');

            $this->reset();

            return $this->redirect(route('posts.index'), navigate: true);
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.posts.edit-post');
    }
}
