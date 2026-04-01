<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    // methods for auth registration
    public function register(array $data);

    // methods for auth login
    public function login(array $data);

    // methods for auth logout
    public function logout();
}
