<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;

class SettingPolicy
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

    public function index(User $user) {
        return in_array($user->group()->first()->name, ['Admin', 'Moderator']);
    }

    public function add(User $user) {
        return $user->group()->first()->name == 'Admin';
    }

    public function delete(User $user) {
        return $user->group()->first()->name == 'Admin';
    }

    public function name(User $user) {
        return $user->group()->first()->name == 'Admin';
    }
}
