<?php

declare(strict_types=1);

namespace App;

use App\Enum\HttpMethod;
use App\Exception\BadRequestMethodException;
use App\Exception\RouteNotFoundException;
use App\Exception\ViewNotFoundException;

/**
 * @method Router get(string $route, array $action)
 * @method Router post(string $route, array $action)
 * @method Router patch(string $route, array $action)
 * @method Router delete(string $route, array $action)
 */
class Router
{
    private array $routes;

    private function register(string $requestMethod, string $route, array $action): void
    {
        $this->routes[$requestMethod][$route] = $action;
    }

    public function __call(string $name, array $arguments): self
    {
        $functionName = strtoupper($name);


        $httpMethod = HttpMethod::tryFrom($functionName);

        if ($httpMethod === null) {
            throw new BadRequestMethodException($functionName);
        }

        $this->register($httpMethod->value, $arguments[0], $arguments[1]);

        return $this;
    }

    public function resolve(string $requestUri, string $requestMethod): mixed
    {

        if (!HttpMethod::tryFrom($requestMethod)) {
            throw new BadRequestMethodException($requestMethod);
        }

        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;


        if (!$action) {
            throw new RouteNotFoundException($route);
        }

        if (is_array($action)) {
            [$class, $method] = $action;
            $params = $action[2] ?? [];


            if (class_exists($class)) {
                $class = new $class();


                if (method_exists($class, $method)) {
                    return call_user_func_array([$class, $method], $params);
                }
            }
        }

        throw new RouteNotFoundException($route);
    }
}