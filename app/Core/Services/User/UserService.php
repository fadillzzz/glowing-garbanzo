<?php

namespace App\Core\Services\User;

use App\Core\Exceptions\Auth\AuthException;
use App\Core\Interfaces\User\UserRepository;
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
            throw new AuthException();
        }

        return $user;
    }

    public function create($user): User
    {
        $user['password'] = Hash::make($user['password']);

        return $this->userRepo->create($user);
    }

    public function getAll(): array
    {
        return $this->userRepo->getAll();
    }
}
