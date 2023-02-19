<?php

namespace App\Core\Services\Auth;

use App\Core\Interfaces\Auth\TokenRepository;
use App\Models\User;

class TokenService
{
    private TokenRepository $tokenRepo;

    public function __construct(TokenRepository $tokenRepo)
    {
        $this->tokenRepo = $tokenRepo;
    }

    public function getUser(string $token): User|null
    {
        return $this->tokenRepo->getUser($token);
    }

    public function createToken(User $user): string
    {
        return $this->tokenRepo->createToken($user);
    }
}
