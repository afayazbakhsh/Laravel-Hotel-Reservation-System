<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    protected $users;

    //get user by email
    public function getUserByEmail($userEmail)
    {
        return User::where('email', $userEmail)->first();
    }
}
