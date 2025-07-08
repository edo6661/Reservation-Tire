<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Enums\UserRole;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected User $model) {}

    public function findById(int $id): ?User
    {
        return $this->model->with(['customer'])->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->with(['customer'])->where('email', $email)->first();
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['customer'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getByRole(UserRole $role, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['customer'])
            ->where('role', $role)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function getByRole(UserRole $role, int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
}