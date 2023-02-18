<?php

namespace App\DAL;

use App\Core\Interfaces\TokenInterface;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class DBToken implements TokenInterface
{
    public function getUser(string $token): User|null
    {
        $dbToken = PersonalAccessToken::findToken($token);

        if ($dbToken !== null) {
            return $dbToken->tokenable()->first();
        }

        return null;
    }
}
