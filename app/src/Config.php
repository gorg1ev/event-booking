<?php

namespace App;

/**
 * @property-read array $db
 */
class Config
{
    protected array $config = [];

    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'driver' => $env['DB_DRIVER'],
                'database' => $env['DB_DATABASE'],
                'host' => $env['DB_HOST'],
                'username' => $env['DB_USERNAME'],
                'password' => $env['DB_PASSWORD']
            ]
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }
}