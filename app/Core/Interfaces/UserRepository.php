<?php

namespace App\Core\Interfaces;

use App\Models\User;

interface UserRepository
{
    public function getByUsername(string $username): User|null;
}
