<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    private const ROLE_ADMIN = 'admin';
    private const ROLE_USER = 'user';
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$this->hasRole($request, $role)) {
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
    private function hasRole(Request $request, string $role): bool
    {
        $bearerToken = $request->bearerToken();
        if (empty($bearerToken)) {
            return false;
        }
        $token = PersonalAccessToken::findToken($bearerToken);
        $user = $token->tokenable;

        return $this->compareRole($user->role, $role);
    }

    /**
     *
     * @param string $userRole
     * @param string $checkedRole
     * @return bool
     */
    private function compareRole(string $userRole, string $checkedRole): bool
    {
        if($userRole === self::ROLE_ADMIN) {
            return true;
        }
        if($userRole === self::ROLE_USER && $checkedRole === self::ROLE_USER) {
            return true;
        }

        return false;
    }

}
