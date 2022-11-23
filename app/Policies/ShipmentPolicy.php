<?php

namespace App\Policies;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
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
        return  $user->is_super || $user->hasPermission('shipments.index');
    }

    public function viewAnyOne(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-shipments.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return  $user->is_super || $user->hasPermission('shipments.show');
    }

    public function viewShow(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-shipments.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
       return  $user->is_super || $user->hasPermission('shipments.create');
    }

    public function createAny(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-shipments.show');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return  $user->is_super || $user->hasPermission('shipments.update');
    }

    public function updateAny(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-shipments.update');
    }
    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return  $user->is_super || $user->hasPermission('shipments.destroy');
    }

    public function deleteAny(User $user)
    {
        return  $user->is_super || $user->hasPermission('warehouse-shipments.destroy');
    }
    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Shipment  $shipment
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
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
