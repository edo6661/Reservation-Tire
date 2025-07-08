<?php

namespace App\Exceptions\Contact;

use Exception;

class CustomerNotFoundException extends Exception
{
    public function __construct(string $message = "Customer not found", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}