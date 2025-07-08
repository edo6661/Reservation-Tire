<?php

namespace App\Services;



use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function getAllUsers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getAllPaginated($perPage);
    }

    public function getUsersByRole(UserRole $role, int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getByRole($role, $perPage);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? UserRole::CUSTOMER;
        
        return $this->userRepository->create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        $user = $this->userRepository->findById($id);
        
        if (!$user) {
            return false;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->update($user, $data);
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->userRepository->findById($id);
        
        if (!$user) {
            return false;
        }

        return $this->userRepository->delete($user);
    }
}

interface UserServiceInterface
{
    public function getAllUsers(int $perPage = 15): LengthAwarePaginator;
    public function getUsersByRole(UserRole $role, int $perPage = 15): LengthAwarePaginator;
    public function getUserById(int $id): ?User;
    public function createUser(array $data): User;
    public function updateUser(int $id, array $data): bool;
    public function deleteUser(int $id): bool;
}
