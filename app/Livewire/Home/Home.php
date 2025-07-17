<?php

namespace App\Livewire\Home;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Home extends Component
{
    use WithPagination;

    public function toggleLike($postId)
    {
        $user = request()->user();
        $post = Post::findOrFail($postId);
        $teamId = $user->currentTeam?->id;

        if (!$teamId) {
            throw new \Exception('User is not assigned to a team.');
        }

        $likeExists = $post->likes()->where('user_id', $user->id)->exists();

        if ($likeExists) {
            $post->likes()->detach($user->id);
        } else {
            $post->likes()->attach($user->id, ['team_id' => $teamId]);
        }
    }

    public function likedPost()
    {
        $user = Auth::user();

        $likedPosts = $user->likedPosts()
            ->with(['user:id,name'])
            ->withCount('likes')
            ->paginate(10);

        $likedPosts->map(function ($post) use ($user) {
            $post->liked = $post->likes->contains($user->id);
            return $post;
        });

        return view('liked-posts', ['posts' => $likedPosts]);
    }

    public function render()
    {
        $posts = Post::with('likes')->withCount('likes')
            ->where('status', 'published')
            ->paginate(10);
        return view('dashboard', [
            'posts' => $posts
        ]);
    }
}
