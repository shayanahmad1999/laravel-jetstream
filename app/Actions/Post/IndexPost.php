<?php

namespace App\Actions\Post;

use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class IndexPost
{
    use AsAction;

    public function handle()
    {
        $user = auth()->user();
        $team = $user->currentTeam;

        if ($user->isSuperAdmin()) {
            return Post::with(['team', 'user'])
                ->latest()
                ->paginate(10);
        }

        if ($user->isAdmin() && $team) {
            return $team->posts()
                ->with(['team', 'user'])
                ->latest()
                ->paginate(10);
        }

        if ($user->isCreator() && $team) {
            return Post::whereBelongsTo($team)
                ->whereBelongsTo($user)
                ->with(['team', 'user'])
                ->latest()
                ->paginate(10);
        }

        return collect();
    }
}
