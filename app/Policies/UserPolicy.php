<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->isSuperAdmin()
            ? Response::allow()
            : Response::deny('Only super admins can view user lists.');
    }

    /**
     * Determine whether the user can view the model.
     * Users can view their own profile, or if they're a super admin.
     */
    public function view(User $user, User $model): Response
    {
        return ($user->id === $model->id || $user->isSuperAdmin())
            ? Response::allow()
            : Response::deny('You may only view your own profile.');
    }

    /**
     * Determine whether the user can create models.
     * Generally locked down, but you can change this logic later.
     */
    public function create(User $user): Response
    {
        return $user->isSuperAdmin()
            ? Response::allow()
            : Response::deny('Only super admins can create new users.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        return $user->isSuperAdmin()
            ? Response::allow()
            : Response::deny('Only super admins can update user data.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        return $user->isSuperAdmin()
            ? Response::allow()
            : Response::deny('Only super admins can delete users.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): Response
    {
        return Response::deny('Restore is disabled.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): Response
    {
        return Response::deny('Permanent deletion is restricted.');
    }

    /**
     * Custom logic to change a user’s role.
     */
    public function changeRole(User $user, User $model): Response
    {
        return $user->isSuperAdmin()
            ? Response::allow()
            : Response::deny('Only super admins can change user roles.');
    }
}
