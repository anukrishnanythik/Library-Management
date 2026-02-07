<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthService
{
    /**
     * Login user and generate API token
     *
     * @param string $email
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new Exception('Invalid credentials');
        }

        $token = $user->createToken('Library-App')->plainTextToken;

        return [
            'access_token' => $token,
            'user' => $user,
        ];
    }

    /**
     * Logout user by deleting all tokens
     *
     * @param User $user
     * @return bool
     * @throws Exception
     */
    public function logout(User $user): bool
    {
        return (bool) $user->tokens()->delete();
    }
}
