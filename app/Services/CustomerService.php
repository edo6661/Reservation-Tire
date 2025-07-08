<?php

namespace App\Services;

use App\Exceptions\Contact\CustomerNotFoundException;
use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Repositories\CustomerRepositoryInterface;


interface CustomerServiceInterface
{
    public function getPaginatedCustomers(int $perPage = 15): LengthAwarePaginator;
    public function getCustomerById(int $id): ?Customer;
    public function getCustomerByUserId(int $userId): ?Customer;
    public function createCustomer(array $data): Customer;
    public function updateCustomer(int $id, array $data): Customer;
    public function deleteCustomer(int $id): bool;
}
class CustomerService implements CustomerServiceInterface
{
    public function __construct(protected CustomerRepositoryInterface $customerRepository) {}

    public function getPaginatedCustomers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->customerRepository->getAllPaginated($perPage);
    }

    public function getCustomerById(int $id): ?Customer
    {
        $customer = $this->customerRepository->findById($id);
        if (!$customer) {
            throw new CustomerNotFoundException("Customer dengan ID {$id} tidak ditemukan.");
        }
        return $customer;
    }

    public function getCustomerByUserId(int $userId): ?Customer
    {
        return $this->customerRepository->findByUserId($userId);
    }

    public function createCustomer(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            return $this->customerRepository->create($data);
        });
    }

    public function updateCustomer(int $id, array $data): Customer
    {
        return DB::transaction(function () use ($id, $data) {
            $customer = $this->getCustomerById($id);
            $this->customerRepository->update($customer, $data);
            return $customer->fresh();
        });
    }

    public function deleteCustomer(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $customer = $this->getCustomerById($id);
            return $this->customerRepository->delete($customer);
        });
    }
}