<?php

namespace App\Http\Controllers\Users;

use App\Core\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function index(Request $request): array
    {
        return ['users' => $this->userService->getAll()];
    }

    public function store(Request $request): Response
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', 'in:admin,manager,user'],
        ]);

        $user = $this->userService->create([
            'username' => $request->username,
            'password' => $request->password
        ]);

        return response(['user' => $user], Response::HTTP_CREATED);
    }
}
