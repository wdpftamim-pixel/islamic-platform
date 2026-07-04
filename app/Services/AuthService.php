<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public function register(array $data): array
    {
        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    public function login(array $data): array
    {
            if (! Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            ])) {

                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials'],
                ]);
            }

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];

    }
    public function logout($user): void
    {
    $user->currentAccessToken()->delete();
    }


}
