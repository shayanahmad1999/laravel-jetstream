<?php

namespace App\Livewire\Posts;

use App\Actions\Post\IndexPost as PostIndexPost;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class IndexPost extends Component
{
    use WithPagination;
    public function updateStatus($id)
    {
        $post = Post::findOrFail($id);
        $post->update(['status' => $post->status === 'draft' ? 'published' : 'draft']);
    }

    public function delete($id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->delete();
            session()->flash('success', 'Post deleted successfully!');
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }

    public function render()
    {
        $posts = (new PostIndexPost())->handle();
        return view('livewire.posts.index-post', [
            'posts' => $posts
        ]);
    }
}
