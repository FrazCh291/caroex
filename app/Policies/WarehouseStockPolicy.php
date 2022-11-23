<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WarehouseStock;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehouseStockPolicy
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
        return $user->is_super ||  $user->hasPermission('warehouse-stocks.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WarehouseStock  $warehouseStock
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
         return $user->is_super || $user->hasPermission('warehouse-stocks.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-stocks.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WarehouseStock  $warehouseStock
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-stocks.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WarehouseStock  $warehouseStock
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-stocks.destroy');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WarehouseStock  $warehouseStock
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
     * @param  \App\Models\WarehouseStock  $warehouseStock
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
