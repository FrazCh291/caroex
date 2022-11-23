<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
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
    public function index(User $user)
    {
        return $user->is_super || $user->is_owner || $user->hasPermission('subscriptions.index');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->is_super || $user->is_owner || $user->hasPermission('subscriptions.index');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function start(User $user)
    {
        return $user->is_super || $user->is_owner || $user->hasPermission('subscriptions.index');
    }
}
