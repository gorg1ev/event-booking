<?php

namespace App\Exception;

class EventNotFoundException extends \Exception
{
    protected $message = 'Event not found';
}