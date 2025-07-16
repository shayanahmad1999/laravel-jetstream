<?php

namespace App\Actions\Post;

use Lorisleiva\Actions\Concerns\AsAction;

class IndexPost
{
    use AsAction;

    public function handle()
    {
        $team = auth()->user()->currentTeam;
        return $team
            ? $team->posts()->with('team', 'user')->latest()->paginate(10)
            : collect();
    }
}
