<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $users;

    public function __construct(User $users){

        $this->users = $users;
    }

    //get user with email
    public function getUserByEmail($userEmail)
    {
        return $this->users->where('email',$userEmail)->first();
    }
}
