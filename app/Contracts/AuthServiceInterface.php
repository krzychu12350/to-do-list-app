<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(array $data): array;
    public function login(array $data): array;
    public function logout($user): void;

    public function validateToken(string $token): bool;
}
