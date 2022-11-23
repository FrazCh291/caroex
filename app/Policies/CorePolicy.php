<?php

namespace App\Policies;

use App\Models\Core;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorePolicy
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
        return $user->is_super || $user->hasPermission('cores.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Core $core
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->is_super || $user->hasPermission('cores.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $authCompany = Auth::user()->company()->first();

//        return ($user->is_super || $user->isMemberOf($authCompany) || ($user->is_owner && $user->isMemberOf($authCompany)));
        return ($user->is_super ||  $user->hasPermission('cores.view'));
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Core $core
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->is_super || $user->hasPermission('cores.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Core $core
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->hasPermission('cores.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Core $core
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
     * @param \App\Models\Core $core
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        //
    }
}
