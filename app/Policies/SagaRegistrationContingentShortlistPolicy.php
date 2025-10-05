<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\SagaRegistrationContingentShortlist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SagaRegistrationContingentShortlistPolicy
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
    public function view(User $user, SagaRegistrationContingentShortlist $sagaRegistrationContingentShortlist): bool
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
    public function update(User $user, SagaRegistrationContingentShortlist $sagaRegistrationContingentShortlist): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SagaRegistrationContingentShortlist $sagaRegistrationContingentShortlist): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SagaRegistrationContingentShortlist $sagaRegistrationContingentShortlist): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SagaRegistrationContingentShortlist $sagaRegistrationContingentShortlist): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
    }
}
