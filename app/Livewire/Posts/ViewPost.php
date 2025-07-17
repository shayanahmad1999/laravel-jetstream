<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ViewPost extends Component
{

    public Post $post;

    public function mount(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        if (!auth()->user()->can('view', $post)) {
            return $this->redirect(URL::previous(), navigate: true);
        }

        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.posts.view-post');
    }
}
