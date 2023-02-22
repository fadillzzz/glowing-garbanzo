<?php

namespace App\Http\Middleware;

use App\Core\Services\Auth\TokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasUserPermission
{
    private TokenService $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $param): Response
    {
        $auth = $request->header('Authorization');
        $parts = explode(' ', $auth);
        $token = '';

        if (count($parts) >= 2) {
            $token = $parts[1];
        }

        $user = $this->tokenService->getUser($token);
        $id = (int) $request->$param;

        if ($user->role === 'admin' ||
            $user->role === 'manager' ||
            ($user->role === 'user' && $user->id === $id)) {
            return $next($request);
        }

        return response('', 403);
    }
}
