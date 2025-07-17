<?php

namespace App\Livewire\Home;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Home extends Component
{
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

        $role = $user->role; // assuming 'SuperAdmin', 'Admin', 'Creator', or 'Guest'

        switch ($role) {
            case 'Super Admin':
                $likedPosts = Post::with(['user:id,name', 'likes'])
                    ->withCount('likes')
                    ->whereHas('likes')
                    ->get();
                break;

            case 'Admin':
                $likedPosts = Post::with(['user:id,name', 'likes'])
                    ->withCount('likes')
                    ->where(function ($query) use ($user) {
                        $query->whereHas('likes', fn($q) => $q->where('user_id', $user->id))
                            ->orWhereHas('likes', fn($q) => $q->where('team_id', $user->team_id));
                    })
                    ->get();
                break;

            case 'Creator':
                $likedPosts = Post::with(['user:id,name', 'likes'])
                    ->withCount('likes')
                    ->where('user_id', $user->id)
                    ->get();
                break;

            default: // Guest
                $likedPosts = $user->likedPosts()
                    ->with(['user:id,name', 'likes'])
                    ->withCount('likes')
                    ->get();
                break;
        }

        // Optional: mark liked status
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
