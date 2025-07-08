<?php

namespace App\Repositories;
use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
interface CustomerRepositoryInterface
{
    public function findById(int $id): ?Customer;
    public function findByUserId(int $userId): ?Customer;
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Customer;
    public function update(Customer $customer, array $data): bool;
    public function delete(Customer $customer): bool;
}

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(protected Customer $model) {}

    public function findById(int $id): ?Customer
    {
        return $this->model->with(['user', 'reservations'])->find($id);
    }

    public function findByUserId(int $userId): ?Customer
    {
        return $this->model->with(['user', 'reservations'])->where('user_id', $userId)->first();
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['user', 'reservations'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data): Customer
    {
        return $this->model->create($data);
    }

    public function update(Customer $customer, array $data): bool
    {
        return $customer->update($data);
    }

    public function delete(Customer $customer): bool
    {
        return $customer->delete();
    }
}