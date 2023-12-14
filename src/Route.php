<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Route
{
    public function __construct(
        public readonly string $url,
        public readonly string $method,
        private readonly array $callback
    )
    {
    }

    public function match(Request $request): bool
    {
        return $this->url === $request->getPathInfo() && $this->method === $request->getMethod();
    }

    public function run(Request $request): Response
    {
        [$controllerClass, $method] = $this->callback;

        $controller = new $controllerClass;

        return $controller->$method();
    }
}
