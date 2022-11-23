<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return  $user->is_super || $user->hasPermission('packages.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function view(User $user)
    {
        return  $user->is_super || $user->hasPermission('packages.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return  $user->is_super || $user->hasPermission('packages.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function update(User $user)
    {
        return  $user->is_super || $user->hasPermission('packages.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function delete(User $user)
    {
        return  $user->is_super || $user->hasPermission('packages.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function restore(User $user, Package $package)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Package $package
     * @return mixed
     */
    public function forceDelete(User $user, Package $package)
    {
        //
    }
}
