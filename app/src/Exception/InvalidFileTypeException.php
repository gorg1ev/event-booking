<?php

namespace App\Exception;

class InvalidFileTypeException extends \Exception
{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}