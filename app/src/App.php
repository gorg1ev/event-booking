<?php

namespace App;

use App\Exception\BadRequestMethodException;
use App\Exception\RouteNotFoundException;

class App
{
    private static DB $db;

    public function __construct(protected Router $router, protected array $request, protected Config $config)
    {
        static::$db = new DB($this->config->db);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve($this->request['uri'], $this->request['method']);
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
            exit;
        } catch (BadRequestMethodException) {
            http_response_code(400);

            echo '400';
            exit;
        }
    }
}