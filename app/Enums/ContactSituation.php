<?php

namespace App\Enums;

enum ContactSituation: string
{
    case ANSWERED = 'answered';
    case UNANSWERED = 'unanswered';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::ANSWERED => 'Answered',
            self::UNANSWERED => 'Unanswered',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ANSWERED => 'success',
            self::UNANSWERED => 'warning',
        };
    }
}