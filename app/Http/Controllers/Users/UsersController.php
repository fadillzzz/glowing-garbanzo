<?php

namespace App\Http\Controllers\Users;

use App\Core\Exceptions\Common\ItemNotFoundException;
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
            'password' => $request->password,
            'role' => $request->role
        ]);

        return response(['user' => $user], Response::HTTP_CREATED);
    }

    public function update(Request $request, string $id): Response
    {
        $request->validate([
            'password' => [Password::defaults()],
            'role' => ['in:admin,manager,user'],
        ]);

        if (! $this->userService->exists($id)) {
            throw new ItemNotFoundException();
        }

        $this->userService->update($id, array_filter([
            'role' => $request->role,
            'password' => $request->password,
        ]));

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function destroy(Request $request, string $id): Response
    {
        if (! $this->userService->exists($id)) {
            throw new ItemNotFoundException();
        }

        $this->userService->delete($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
