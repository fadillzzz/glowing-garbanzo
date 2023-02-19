<?php

namespace App\DAL\User;

use App\Core\Interfaces\User\UserRepository;
use App\Models\User;

class DBUser implements UserRepository
{
    public function getByUsername(string $username): User|null
    {
        return User::where('username', $username)->first();
    }

    public function getAll(): array
    {
        return User::all()->toArray();
    }

    public function create(array $user): User
    {
        return User::create($user);
    }
}
