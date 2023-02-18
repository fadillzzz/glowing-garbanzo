<?php

namespace App\Http\Controllers\Auth;

use App\Core\Services\TokenService;
use App\Core\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    private UserService $userService;
    private TokenService $tokenService;

    public function __construct(UserService $userService, TokenService $tokenService)
    {
        $this->userService = $userService;
        $this->tokenService = $tokenService;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = $this->userService->auth($request->username, $request->password);

        $token = $this->tokenService->createToken($user);

        return response(
            ['token' => $token],
            Response::HTTP_CREATED
        );
    }
}
