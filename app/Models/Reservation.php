<?php
namespace App\Models;

use App\Enums\ReservationStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'service',
        'datetime',
        'coupon_code',
        'customer_contact',
        'management_notes',
        'simple_questionnaire',
        'customer_id',
    ];

    protected $casts = [
        'status' => ReservationStatus::class,
        'service' => ServiceType::class,
        'datetime' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [ReservationStatus::APPLICATION, ReservationStatus::CONFIRMED]);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('datetime', $date);
    }

    public function scopeForTime($query, $time)
    {
        return $query->whereTime('datetime', $time);
    }
}