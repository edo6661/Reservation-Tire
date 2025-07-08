<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Carbon\Carbon;
class ReservationAvailability extends Model
{
    use HasFactory;

    protected $table = 'reservation_availability';

    protected $fillable = [
        'date',
        'time',
        'is_available',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'is_available' => 'boolean',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

    public function scopeForTime($query, $time)
    {
        return $query->where('time', $time);
    }

    public static function isSlotAvailable($date, $time): bool
    {
        
        $availability = self::where('date', $date)
            ->where('time', $time)
            ->first();

        if ($availability) {
            return $availability->is_available;
        }

        
        $existingReservation = Reservation::where('datetime', Carbon::parse($date . ' ' . $time))
            ->whereIn('status', [ReservationStatus::APPLICATION, ReservationStatus::CONFIRMED])
            ->exists();

        return !$existingReservation;
    }

    public static function getAvailableSlots($date): array
    {
        $slots = [];
        $workingHours = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

        foreach ($workingHours as $time) {
            if (self::isSlotAvailable($date, $time)) {
                $slots[] = $time;
            }
        }

        return $slots;
    }
}