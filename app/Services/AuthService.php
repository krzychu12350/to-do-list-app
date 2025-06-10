<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService implements AuthServiceInterface
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return [
            'user'  => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        return [
            'user'  => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function validateToken(string $token): bool
    {
        // Use Laravel Sanctum's PersonalAccessToken model to find the token
        $accessToken = PersonalAccessToken::findToken($token);

        // If token exists and not expired (you may check expiry if needed), return true
        return $accessToken !== null;
    }
}
