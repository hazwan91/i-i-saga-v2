<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\ContingentRole;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContingentRolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContingentRole $contingentRole): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContingentRole $contingentRole): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContingentRole $contingentRole): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContingentRole $contingentRole): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContingentRole $contingentRole): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }
}
