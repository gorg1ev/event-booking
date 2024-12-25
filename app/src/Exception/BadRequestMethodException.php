<?php

namespace App\Exception;

class BadRequestMethodException extends \Exception
{
    public function __construct(string $requestMethod = '')
    {
        $message = "Bad Request Method";
        if ($requestMethod) {
            $message = $message . ' ' . $requestMethod;
        }

        $message = $message . '.';
        parent::__construct($message);
    }
}