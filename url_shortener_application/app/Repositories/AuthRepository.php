<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    // register interface method implementation
    public function register(array $data)
    {
        // to create a user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // create a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    // login interface method implementation
    public function login(array $data)
    {
        //  if auth attempts to find the valid credentials
        if (!Auth::attempt(
            [
                'email' => $data['email'],
                'password' => $data['password']
            ]
        )) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials']
            ]);
        }
        // if credentials are valid, get the authenticated user
        $user = Auth::user();
        // create a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    // logout interface method implementation
    public function logout()
    {
        // to revoke the token of the authenticated user
        $user = Auth::user();
        $user->tokens()->delete();

        return [
            'message' => 'User logged out successfully'
        ];
    }
}
