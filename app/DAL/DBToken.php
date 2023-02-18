<?php

namespace App\DAL;

use App\Core\Interfaces\TokenRepository;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class DBToken implements TokenRepository
{
    public function getUser(string $token): User|null
    {
        $dbToken = PersonalAccessToken::findToken($token);

        if ($dbToken !== null) {
            return $dbToken->tokenable()->first();
        }

        return null;
    }

    public function createToken(User $user): string
    {
        return $user->createToken($user->username)->plainTextToken;
    }
}
