<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('user.index');
    }

    public function viewAnyuser(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('users.index');
    }
    

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('user.show');
    }

    public function viewuser(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('users.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('user.create');
    }

    public function createuser(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('users.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('user.update');
    }


    public function updateuser(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('users.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('user.destroy');
    }

    public function deleteuser(User $user)
    {
        return $user->is_super || $user->is_owner || $user->is_admin || $user->hasPermission('users.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
