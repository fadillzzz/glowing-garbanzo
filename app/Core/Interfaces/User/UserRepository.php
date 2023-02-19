<?php

namespace App\Core\Interfaces\User;

use App\Models\User;

interface UserRepository
{
    public function getByUsername(string $username): User|null;

    public function getAll(): array;
}
