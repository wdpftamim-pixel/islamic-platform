<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Traits\ApiResponseTrait;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService
            ->register($request->validated());

        return $this->successResponse(
            data: $result,
            message: 'Registration successful',
            status: 201
        );
    }
    public function login(LoginRequest $request): JsonResponse
    {
    $result = $this->authService
    ->login($request->validated());

    return $this->successResponse(
        data: $result,
        message: 'Login successful'
    );

    }
    public function me(): JsonResponse
    {
    return $this->successResponse(
    data: auth()->user(),
    message: 'Authenticated user fetched successfully'
    );
    }
    public function logout(): JsonResponse
    {
    $this->authService->logout(auth()->user());
    return $this->successResponse(
        message: 'Logout successful'
    );
    }


}
