<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\SagaRegistrationTechnical;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SagaRegistrationTechnicalPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [Role::SUPER_ADMIN]);
        // return in_array(Auth::user()->role, [
        //     Role::SUPER_ADMIN->value,
        //     Role::ADMIN->value,
        //     Role::MSN->value,
        //     Role::KBSS->value,
        //     Role::VIP->value,
        //     Role::KETUA_PENYELARAS_ZON->value,
        //     Role::PENYELARAS_ZON->value,
        //     Role::KETUA_TEKNIKAL_DELIGAT->value,
        //     Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        // ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SagaRegistrationTechnical $sagaRegistrationTechnical): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN->value,
            // Role::KETUA_PENYELARAS_ZON->value,
            // Role::PENYELARAS_ZON->value,
            // Role::KETUA_TEKNIKAL_DELIGAT->value,
            // Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN->value,
            // Role::KETUA_TEKNIKAL_DELIGAT->value,
            // Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SagaRegistrationTechnical $sagaRegistrationTechnical): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN->value,
            // Role::KETUA_TEKNIKAL_DELIGAT->value,
            // Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SagaRegistrationTechnical $sagaRegistrationTechnical): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN->value,
            // Role::KETUA_TEKNIKAL_DELIGAT->value,
            // Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SagaRegistrationTechnical $sagaRegistrationTechnical): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN->value,
            // Role::KETUA_TEKNIKAL_DELIGAT->value,
            // Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SagaRegistrationTechnical $sagaRegistrationTechnical): bool
    {
        return in_array($user->role, [
            Role::SUPER_ADMIN,
            // Role::ADMIN->value,
            // Role::KETUA_TEKNIKAL_DELIGAT->value,
            // Role::PEGAWAI_TEKNIKAL_SUKAN->value,
        ]);
    }
}
