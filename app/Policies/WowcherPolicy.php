<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wowcher;
use Illuminate\Auth\Access\HandlesAuthorization;

class WowcherPolicy
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
        return $user->is_super || $user->hasPermission('wowchers.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wowcher $wowcher
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->is_super || $user->hasPermission('wowchers.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_super || $user->hasPermission('wowchers.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wowcher $wowcher
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->is_super || $user->hasPermission('wowchers.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wowcher $wowcher
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->hasPermission('wowchers.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wowcher $wowcher
     * @return mixed
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Wowcher $wowcher
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
