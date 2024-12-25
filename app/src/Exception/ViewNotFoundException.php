<?php

namespace App\Exception;

class ViewNotFoundException extends \Exception
{
    public function __construct($view = '')
    {
        $message = 'View Not Found';

        if ($view) {
            $message = $message . ' ' . $view;
        }

        $message = $message . '.';
        parent::__construct($message);
    }
}