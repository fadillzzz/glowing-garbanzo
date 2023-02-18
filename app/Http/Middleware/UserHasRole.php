<?php

namespace App\Http\Middleware;

use App\Core\Interfaces\TokenInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserHasRole
{
    private $tokenRepo;

    public function __construct(TokenInterface $tokenRepo)
    {
        $this->tokenRepo = $tokenRepo;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $auth = $request->header('Authorization');
        $parts = explode(' ', $auth);
        $token = '';

        if (count($parts) >= 2) {
            $token = $parts[1];
        }

        $user = $this->tokenRepo->getUser($token);

        if ($user !== null && $user->role === $role) {
            return $next($request);
        }

        return response('', 403);
    }
}
