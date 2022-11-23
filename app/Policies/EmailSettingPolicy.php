<?php

namespace App\Policies;

use App\Models\EmailSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailSettingPolicy
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
         return $user->is_super ||  $user->hasPermission('email-settings.index');
    }

    public function viewAnyful(User $user)
    {
         return $user->is_super ||  $user->hasPermission('email-setting.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmailSetting  $emailSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->is_super || $user->hasPermission('email-settings.show');
    }

    public function viewful(User $user)
    {
        return $user->is_super || $user->hasPermission('email-setting.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->is_super || $user->hasPermission('email-settings.create');
    }

    public function createful(User $user)
    {
        return $user->is_super || $user->hasPermission('email-setting.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmailSetting  $emailSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->is_super || $user->hasPermission('email-settings.update');
    }

    public function updateful(User $user)
    {
        return $user->is_super || $user->hasPermission('email-setting.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmailSetting  $emailSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->hasPermission('email-settings.destroy');
    }

    public function deleteful(User $user)
    {
        return $user->is_super || $user->hasPermission('email-setting.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmailSetting  $emailSetting
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
     * @param  \App\Models\EmailSetting  $emailSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
