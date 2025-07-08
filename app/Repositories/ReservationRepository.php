<?php

namespace App\Repositories;
use App\Models\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReservationRepositoryInterface
{
    public function findById(int $id): ?Reservation;
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;
    public function getByCustomerId(int $customerId): Collection;
    public function getByDateRange(string $startDate, string $endDate): Collection;
    public function create(array $data): Reservation;
    public function update(Reservation $reservation, array $data): bool;
    public function delete(Reservation $reservation): bool;
}


class ReservationRepository implements ReservationRepositoryInterface
{
    public function __construct(protected Reservation $model) {}

    public function findById(int $id): ?Reservation
    {
        return $this->model->with(['customer.user'])->find($id);
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with(['customer.user'])
            ->orderBy('datetime', 'desc')
            ->paginate($perPage);
    }

    public function getByCustomerId(int $customerId): Collection
    {
        return $this->model->with(['customer.user'])
            ->where('customer_id', $customerId)
            ->orderBy('datetime', 'desc')
            ->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->model->with(['customer.user'])
            ->whereBetween('datetime', [$startDate, $endDate])
            ->orderBy('datetime', 'asc')
            ->get();
    }

    public function create(array $data): Reservation
    {
        return $this->model->create($data);
    }

    public function update(Reservation $reservation, array $data): bool
    {
        return $reservation->update($data);
    }

    public function delete(Reservation $reservation): bool
    {
        return $reservation->delete();
    }
}