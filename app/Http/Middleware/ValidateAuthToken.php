<?php

namespace App\Http\Middleware;

use App\Contracts\AuthServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateAuthToken
{
    public function __construct(private readonly AuthServiceInterface $authService)
    {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
//        $token = $request->bearerToken() ?: $request->header('Authorization');
//
//        if (!$token) {
//            return response()->json(['message' => 'Authorization token missing.'], 401);
//        }
//
//        // Remove "Bearer " prefix if present
//        $token = preg_replace('/^Bearer\s/', '', $token);
//
//        if (! $this->authService->validateToken($token)) {
//            return response()->json(['message' => 'Invalid or expired token.'], 401);
//        }

        $all = $request->all();
//        dd($all);
        $token = $request->bearerToken();

//        dd($token);

//        if (!$token || ! $this->authService->validateToken($token)) {
//            return response()->json(['message' => 'Invalid or expired token.'], 401);
//        }

        return $next($request);
    }
}
