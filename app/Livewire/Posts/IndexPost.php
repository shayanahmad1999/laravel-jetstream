<?php

namespace App\Livewire\Posts;

use App\Actions\Post\IndexPost as PostIndexPost;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class IndexPost extends Component
{
    public function updateStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['status' => $post->status === 'draft' ? 'published' : 'draft']);
    }

    public function render()
    {
        $posts = (new PostIndexPost())->handle();
        return view('livewire.posts.index-post', [
            'posts' => $posts
        ]);
    }
}
