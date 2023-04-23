<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateUserValidationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $validateFields = $this->validateFields($request);
        if ($validateFields->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateFields->errors()
            ], 400);
        }

        return $next($request);
    }

    /**
     *
     * @param Request $request
     * @return \Illuminate\Validation\Validator
     */
    private function validateFields(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );
    }
}
