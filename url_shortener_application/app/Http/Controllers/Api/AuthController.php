<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // injecting the auth repository interface
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    // user registration
    public function register(RegisterRequest $request)
    {
        // validating the request data with form request
        $data = $request->validated();

        $result = $this->authRepository->register($data);

        return response()->json([
            'status' => 201,
            'message' => 'User registered successfully',
            'user' => $result['user'],
            'token' => $result['token'],
        ], 201);
    }

    // user login
    public function login(LoginRequest $request)
    {
        // validating the request data with form request
        $data = $request->validated();

        $result = $this->authRepository->login($data);

        return response()->json([
            'status' => 200,
            'message' => 'User logged in successfully',
            'user' => $result['user'],
            'token' => $result['token'],
        ], 200);
    }

    // user logout
    public function logout(Request $request)
    {
        $this->authRepository->logout();

        return response()->json([
            'status' => 200,
            'message' => 'User logged out successfully',
        ], 200);
    }
}
