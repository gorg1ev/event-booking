<?php

namespace App\Exception;

class EmailAlreadyTakenException extends \Exception
{
    protected $message = 'This email is already in use.';
}