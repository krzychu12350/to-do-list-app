<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\AuthServiceInterface;

class AuthTokenMiddleware
{
    public function __construct(private readonly AuthServiceInterface $authService)
    {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return redirect()->route('login')->withErrors('Unauthorized: No token provided');
        }

        $token = substr($authHeader, 7); // Remove "Bearer "

        // Validate token using your auth service
        if (!$this->authService->validateToken($token)) {
            return redirect()->route('login')->withErrors('Unauthorized: Invalid token');
        }

        // Optionally, you can set the authenticated user in the request here
        // $user = $this->authService->getUserByToken($token);
        // $request->setUserResolver(fn() => $user);

        return $next($request);
    }
}
