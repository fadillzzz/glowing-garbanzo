<?php

namespace App\Http\Controllers\Users;

use App\Core\Services\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return $this->userService->getAll();
    }
}
