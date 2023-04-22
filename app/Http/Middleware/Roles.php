<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!self::hasRole($request, $role)) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => ['Invalid user role']
            ], 401);
        }

        return $next($request);
    }

    /**
     *
     * @param Request $request
     * @param string $role
     * @return boolean
     */
    private static function hasRole(Request $request, string $role): bool
    {
        $bearerToken = $request->bearerToken();
        if (empty($bearerToken)) {
            return false;
        }
        $token = PersonalAccessToken::findToken($bearerToken);
        $user = $token->tokenable;

        return $user->role === $role;
    }
}
