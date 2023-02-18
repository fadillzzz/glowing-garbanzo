<?php

namespace App\DAL;

use App\Core\Interfaces\UserRepository;
use App\Models\User;

class DBUser implements UserRepository
{
    public function getByUsername(string $username): User
    {
        return User::where('username', $username)->first();
    }
}
