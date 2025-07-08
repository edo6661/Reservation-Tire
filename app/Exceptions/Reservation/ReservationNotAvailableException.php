<?php

namespace App\Exceptions\Reservation;

use Exception;

class ReservationNotAvailableException extends Exception
{
    public function __construct(string $message = "Reservation slot not available", int $code = 422)
    {
        parent::__construct($message, $code);
    }
}