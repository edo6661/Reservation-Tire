<?php

namespace App\Exceptions\Contact;

use Exception;

class ContactNotFoundException extends Exception
{
    public function __construct(string $message = "Contact not found", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}