<?php

namespace App\Enums;

enum ServiceType: string
{
    case TIRE_INSTALLATION_PURCHASED = 'Installation of tires purchased at our store';
    case TIRE_REPLACEMENT_SHIPPED = 'Replacement and installation of tires brought in (tires shipped directly to our store)';
    case OIL_CHANGE = 'Oil change';
    case TIRE_STORAGE_REPLACEMENT = 'Tire storage and tire replacement at our store';
    case TIRE_CHANGE_BYOB = 'Change tires by bringing your own (removal and removal of season tires, etc.)';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return $this->value;
    }

    public function shortLabel(): string
    {
        return match($this) {
            self::TIRE_INSTALLATION_PURCHASED => 'Tire Installation (Purchased)',
            self::TIRE_REPLACEMENT_SHIPPED => 'Tire Replacement (Shipped)',
            self::OIL_CHANGE => 'Oil Change',
            self::TIRE_STORAGE_REPLACEMENT => 'Tire Storage & Replacement',
            self::TIRE_CHANGE_BYOB => 'Tire Change (BYOB)',
        };
    }
    public function time(): int
    {
        return match($this) {
            self::TIRE_INSTALLATION_PURCHASED => 50,
            self::TIRE_REPLACEMENT_SHIPPED => 50,
            self::OIL_CHANGE => 40,
            self::TIRE_STORAGE_REPLACEMENT => 40,
            self::TIRE_CHANGE_BYOB => 30,
        };
    }
}
