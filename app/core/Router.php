<?php

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get(string $path, string $controller, string $method): void
    {
        $this->routes['GET'][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function post(string $path, string $controller, string $method): void
    {
        $this->routes['POST'][$path] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function dispatch(string $path, string $requestMethod): void
    {
        $normalizedMethod = $requestMethod === 'HEAD' ? 'GET' : $requestMethod;
        $route = $this->routes[$normalizedMethod][$path] ?? null;

        if (!$route) {
            http_response_code(404);
            echo 'Página não encontrada.';
            return;
        }

        $controller = new $route['controller']();

        $controller->{$route['method']}();
    }
}