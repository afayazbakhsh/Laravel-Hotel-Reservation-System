<?php
namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getUserByEmail($userEmail);
}
