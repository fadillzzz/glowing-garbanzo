<?php

namespace App\Core\Interfaces;

use App\Models\User;

interface TokenInterface
{
    public function getUser(string $token): User|null;
}
