<?php

namespace App\Services;
use App\Models\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ReservationAvailability;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Repositories\ReservationRepositoryInterface;
use App\Exceptions\Reservation\ReservationNotAvailableException;
use App\Exceptions\Reservation\ReservationNotFoundException;

interface ReservationServiceInterface
{
    public function getPaginatedReservations(int $perPage = 15): LengthAwarePaginator;
    public function getReservationById(int $id): ?Reservation;
    public function getCustomerReservations(int $customerId): Collection;
    public function createReservation(array $data): Reservation;
    public function updateReservation(int $id, array $data): Reservation;
    public function cancelReservation(int $id): bool;
    public function confirmReservation(int $id): Reservation;
    public function rejectReservation(int $id): Reservation;
    public function checkAvailability(string $date, string $time): bool;
    public function getAvailableSlots(string $date): array;
    public function delete(int $id): bool;
}
class ReservationService implements ReservationServiceInterface
{
    public function __construct(protected ReservationRepositoryInterface $reservationRepository) {}

    public function getPaginatedReservations(int $perPage = 15): LengthAwarePaginator
    {
        return $this->reservationRepository->getAllPaginated($perPage);
    }

    public function getReservationById(int $id): ?Reservation
    {
        $reservation = $this->reservationRepository->findById($id);
        if (!$reservation) {
            throw new ReservationNotFoundException("Reservation dengan ID {$id} tidak ditemukan.");
        }
        return $reservation;
    }

    public function getCustomerReservations(int $customerId): Collection
    {
        return $this->reservationRepository->getByCustomerId($customerId);
    }

    public function createReservation(array $data): Reservation
    {
        return DB::transaction(function () use ($data) {
            $datetime = Carbon::parse($data['datetime']);
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i');

            
            if (!$this->checkAvailability($date, $time)) {
                throw new ReservationNotAvailableException("Slot waktu {$date} {$time} tidak tersedia atau sudah dipesan.");
            }

            $data['status'] = ReservationStatus::APPLICATION;
            
            if (!isset($data['customer_id']) || empty($data['customer_id'])) {
                $data['customer_id'] = null;
            }

            return $this->reservationRepository->create($data);
        });
    }

    public function updateReservation(int $id, array $data): Reservation
    {
        return DB::transaction(function () use ($id, $data) {
            $reservation = $this->getReservationById($id);
            
            if (isset($data['datetime'])) {
                $newDatetime = Carbon::parse($data['datetime']);
                $oldDatetime = $reservation->datetime;
                
                
                if (!$newDatetime->equalTo($oldDatetime)) {
                    $date = $newDatetime->format('Y-m-d');
                    $time = $newDatetime->format('H:i');
                    
                    
                    if (!$this->checkAvailability($date, $time, $id)) {
                        throw new ReservationNotAvailableException("Slot waktu {$date} {$time} tidak tersedia atau sudah dipesan.");
                    }
                }
            }
            
            $this->reservationRepository->update($reservation, $data);
            return $reservation->fresh();
        });
    }

    public function cancelReservation(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $reservation = $this->getReservationById($id);
        
            if (!$reservation->canBeCancelled()) {
                throw new \Exception("Reservation ini tidak dapat dibatalkan.");
            }
            
            return $this->reservationRepository->update($reservation, [
                'status' => ReservationStatus::REJECTED
            ]);
        });
    }

    public function confirmReservation(int $id): Reservation
    {
        return DB::transaction(function () use ($id) {
            $reservation = $this->getReservationById($id);
            
            $this->reservationRepository->update($reservation, [
                'status' => ReservationStatus::CONFIRMED
            ]);
            
            return $reservation->fresh();
        });
    }

    public function rejectReservation(int $id): Reservation
    {
        return DB::transaction(function () use ($id) {
            $reservation = $this->getReservationById($id);
            
            $this->reservationRepository->update($reservation, [
                'status' => ReservationStatus::REJECTED
            ]);
            
            return $reservation->fresh();
        });
    }

    public function checkAvailability(string $date, string $time, ?int $excludeReservationId = null): bool
    {
        return ReservationAvailability::isSlotAvailable($date, $time, $excludeReservationId);
    }

    public function getAvailableSlots(string $date): array
    {
        return ReservationAvailability::getAvailableSlots($date);
    }
    public function delete(int $id): bool
    {
        $reservation = $this->getReservationById($id);
        return $this->reservationRepository->delete($reservation);
    }
}