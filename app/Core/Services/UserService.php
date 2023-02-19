<?php

namespace App\Core\Services;

use App\Core\Interfaces\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function auth(string $username, string $password): User
    {
        $user = $this->userRepo->getByUsername($username);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user;
    }

    public function getAll(): array
    {
        return $this->userRepo->getAll();
    }
}
