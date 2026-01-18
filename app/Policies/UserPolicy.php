<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser)
    {
        return $authUser->role === 'admin';
    }

    public function updateRole(User $authUser, User $user)
    {
        return $authUser->role === 'admin';
    }
}