<?php

namespace App\Policies;

use App\Models\CurrencyExchange;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyExchangePolicy
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
        return $user->is_super ||  $user->hasPermission('exchanges-rates.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
         return $user->is_super || $user->hasPermission('exchanges-rates.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return  $user->is_super || $user->hasPermission('exchanges-rates.create');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function conversionCreate(User $user)
    {
        return  $user->is_super || $user->hasPermission('currency-converters');
    }
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return  $user->is_super || $user->hasPermission('exchanges-rates.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return  $user->is_super || $user->hasPermission('exchanges-rates.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CurrencyExchange  $currencyExchange
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
     * @param  \App\Models\CurrencyExchange  $currencyExchange
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
