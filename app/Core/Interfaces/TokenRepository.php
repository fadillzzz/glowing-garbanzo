<?php

namespace App\Core\Interfaces;

use App\Models\User;

interface TokenRepository
{
    public function getUser(string $token): User|null;

    public function createToken(User $user): string;
}
