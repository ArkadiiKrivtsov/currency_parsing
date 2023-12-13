<?php

namespace App;

use App\Exceptions\PageNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    private array $routes = [];

    public function register(string $url, string $method, array $callback): void
    {
        $this->routes[] = new Route($url, $method, $callback);
    }

    public function get(string $url, array $callback): void
    {
        $this->register($url, 'GET', $callback);
    }

    public function post(string $url, array $callback): void
    {
        $this->register($url, 'POST', $callback);
    }

    public function run(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route->match($request)) {
                return $route->run($request);
            }
        }

        throw new PageNotFoundException();
    }
}