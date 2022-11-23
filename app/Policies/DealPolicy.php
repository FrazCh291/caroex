<?php

namespace App\Policies;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->is_super || $user->hasPermission('deals.index');
    }

    /**
     * @param User $user
     * @param Deal $deal
     * @return bool
     */
    public function view(User $user)
    {
        return $user->is_super || $user->hasPermission('deals.show');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->is_super || $user->hasPermission('deals.create');
    }

    /**
     * @param User $user
     * @param Deal $deal
     * @return bool
     */

    public function update(User $user)
    {
        return $user->is_super || $user->hasPermission('deals.update');
    }

    public function store(User $user)
    {
        return $user->is_super || $user->hasPermission('deals.create');
    }

    /**
     * @param User $user
     * @param Deal $deal
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->is_super || $user->hasPermission('deals.destroy');
    }

}
