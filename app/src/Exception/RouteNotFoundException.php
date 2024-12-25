<?php

namespace App\Exception;

class RouteNotFoundException extends \Exception
{

    public function __construct(string $route = '')
    {
        $message = 'Route Not Found';
        if ($route) {
            $message = $message . ' ' . $route;
        }

        $message = $message . '.';
        parent::__construct($message);
    }
}