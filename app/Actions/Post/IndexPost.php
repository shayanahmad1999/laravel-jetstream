<?php

namespace App\Actions\Post;

use App\Models\Post;
use Lorisleiva\Actions\Concerns\AsAction;

class IndexPost
{
    use AsAction;

    public function handle(?string $search = null, ?string $userFilter = null)
    {
        $user = auth()->user();
        $team = $user->currentTeam;

        // if ($user->isSuperAdmin()) {
        //     return Post::with(['team', 'user'])
        //         ->latest()
        //         ->paginate(10);
        // }

        // if ($user->isAdmin() && $team) {
        //     return $team->posts()
        //         ->with(['team', 'user'])
        //         ->latest()
        //         ->paginate(10);
        // }

        // if ($user->isCreator() && $team) {
        //     return Post::whereBelongsTo($team)
        //         ->whereBelongsTo($user)
        //         ->with(['team', 'user'])
        //         ->latest()
        //         ->paginate(10);
        // }

        // return collect();

        // Query Logic Optimization with search

        return Post::query()
            ->with(['team', 'user'])
            ->when($user->isSuperAdmin(), fn($q) => $q)
            ->when($user->isAdmin() && $team, fn($q) => $q->whereBelongsTo($team))
            ->when($user->isCreator() && $team, fn($q) =>
            $q->whereBelongsTo($team)->whereBelongsTo($user))
            ->when($search, fn($q) =>
            $q->where(fn($sub) =>
            $sub->where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")))
            ->when($userFilter, fn($q) =>
            $q->whereHas('user', fn($uq) =>
            $uq->where('name', 'like', "%{$userFilter}%")))
            ->latest()
            ->paginate(10);
    }
}
