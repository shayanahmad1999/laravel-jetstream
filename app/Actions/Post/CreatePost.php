<?php

namespace App\Actions\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePost
{
    use AsAction;

    public function handle(array $data): Post
    {
        return Post::create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'content' => $data['content'],
            'image' => $data['image'],
            'user_id' => $data['user_id'] ?? Auth::id(),
            'team_id'    => optional(Auth::user())->currentTeam?->id,
            'status' => $data['status'] ?? 'draft',
        ]);
    }
}
