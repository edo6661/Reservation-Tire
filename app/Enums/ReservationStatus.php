<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case APPLICATION = 'application';
    case CONFIRMED = 'confirmed';
    case REJECTED = 'rejected';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::APPLICATION => 'Application',
            self::CONFIRMED => 'Confirmed',
            self::REJECTED => 'Rejected',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::APPLICATION => 'warning',
            self::CONFIRMED => 'success',
            self::REJECTED => 'danger',
        };
    }
}