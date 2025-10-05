<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\SagaRegistrationCommitee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SagaRegistrationCommiteePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN,
            // Role::URUSETIA_PELAKSANA,
            // Role::MSN,
        ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SagaRegistrationCommitee $sagaRegistrationCommitee): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN,
            // Role::URUSETIA_PELAKSANA,
            // Role::MSN,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if (in_array($user->role, [Role::SUPER_ADMIN])) {
            return true;
        }

        return SagaRegistrationCommitee::isRegistrationOpen();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SagaRegistrationCommitee $sagaRegistrationCommitee): bool
    {
        if (in_array($user->role, [Role::SUPER_ADMIN])) {
            return true;
        }

        return SagaRegistrationCommitee::isRegistrationOpen();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SagaRegistrationCommitee $sagaRegistrationCommitee): bool
    {
        if (in_array($user->role, [Role::SUPER_ADMIN])) {
            return true;
        }

        return SagaRegistrationCommitee::isRegistrationOpen();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SagaRegistrationCommitee $sagaRegistrationCommitee): bool
    {
        if (in_array($user->role, [Role::SUPER_ADMIN])) {
            return true;
        }

        return SagaRegistrationCommitee::isRegistrationOpen();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SagaRegistrationCommitee $sagaRegistrationCommitee): bool
    {
        if (in_array($user->role, [Role::SUPER_ADMIN])) {
            return true;
        }

        return SagaRegistrationCommitee::isRegistrationOpen();
    }
}
