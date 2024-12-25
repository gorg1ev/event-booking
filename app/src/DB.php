<?php

namespace App;

use PDO;

class DB
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $dsn = $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'];
            $this->pdo = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                $config['options'] ?? $defaultOptions
            );
        } catch (\PDOException $e) {
            // TODO write appropriate error
            echo $e->getMessage();
        }
    }


    public function __call(string $name, array $arguments)
    {
        if (method_exists($this->pdo, $name)) {
            return call_user_func_array([$this->pdo, $name], $arguments);
        }

        throw new \BadMethodCallException("Method $name does not exist on PDO.");
    }


}