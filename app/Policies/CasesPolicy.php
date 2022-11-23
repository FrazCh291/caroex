<?php

namespace App\Policies;

use App\Models\Cases;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CasesPolicy
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
         return $user->is_super ||  $user->hasPermission('cases.index');
    }

    public function viewAnyCase(User $user)
    {
         return $user->is_super ||  $user->hasPermission('case.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cases  $cases
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->is_super || $user->hasPermission('cases.show');
    }

    public function viewCase(User $user)
    {
        return $user->is_super || $user->hasPermission('case.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->is_super || $user->hasPermission('cases.create');
    }


    public function createCase(User $user)
    {
        return $user->is_super || $user->hasPermission('case.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cases  $cases
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->is_super || $user->hasPermission('cases.update');
    }

    public function updateCase(User $user)
    {
        return $user->is_super || $user->hasPermission('case.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cases  $cases
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->hasPermission('cases.destroy');
    }


    public function deleteCase(User $user)
    {
        return $user->is_super || $user->hasPermission('case.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cases  $cases
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
     * @param  \App\Models\Cases  $cases
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
