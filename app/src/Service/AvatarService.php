<?php

namespace App\Service;

use App\Session;

class AvatarService
{
    private string $extendion;
    private string $location;

    public function __construct()
    {
    }

    public function getExtendion(): string
    {
        return $this->extendion;
    }

    public function setExtendion(string $fileName): void
    {
        $this->extendion = pathinfo($fileName, PATHINFO_EXTENSION);
    }


    public function getLocation(): string
    {
        return $this->location ?? '';
    }

    public function setLocation(string $dir, string $fullName, string $userId, string $extendion): void
    {
        $name = str_replace(' ', '', strtolower($fullName));
        $this->location = DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $name . '-' . $userId . '.' . $extendion;
    }

    function isValidExtendion(string $extendion): bool
    {
        return !in_array($extendion, ['png', 'jpg']);
    }
}