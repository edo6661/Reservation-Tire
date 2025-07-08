<?php

namespace App\Services;

use App\Repositories\AuthRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;
interface AuthServiceInterface
{
    public function login(array $credentials): bool;
    public function register(array $data): User;
    public function logout(): void;
    public function getCurrentUser(): ?User;
    public function isAuthenticated(): bool;
}
class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected AuthRepositoryInterface $authRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function login(array $credentials): bool
    {
        return $this->authRepository->attempt($credentials);
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? UserRole::CUSTOMER;
        
        $user = $this->userRepository->create($data);
        $this->authRepository->login($user);
        
        return $user;
    }

    public function logout(): void
    {
        $this->authRepository->logout();
    }

    public function getCurrentUser(): ?User
    {
        return $this->authRepository->user();
    }

    public function isAuthenticated(): bool
    {
        return $this->authRepository->check();
    }
}
