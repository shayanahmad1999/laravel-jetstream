<?php

namespace App\Actions\Post;

use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePost
{
    use AsAction;

    public function handle(array $data): Post
    {
        $post = Post::where('slug', $data['slug'])->firstOrFail();
        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'image' => $data['image'],
            'status' => $data['status'],
        ]);

        return $post;
    }
}
