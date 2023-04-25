<?php

namespace AkemiAdam\Basilisk\App\Kernel;

class Route
{
    use Base;

    protected array $routes;

    protected string $currentRoute;

    public function __construct()
    {
        $this->routes = ['GET' => [], 'POST' => []];
    }

    protected function createRoute(string $path, string $verb, \Closure|array $controller) : void
    {
        $this->routes[$verb] += [$path => $controller];

        $this->currentRoute = $path;
    }

    public function get(string $path, \Closure|array $controller) : Route
    {
        $this->createRoute($path, 'GET', $controller);

        return $this;
    }

    public function post(string $path, \Closure|array $controller)
    {
        $this->createRoute($path, 'POST', $controller);

        return $this;
    }

    public function boot() : void
    {
        $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST')
            $this->send($path, 'POST');
        
        else if ($method === 'GET')
            $this->send($path, 'GET');
    }

    protected function send(string $path, string $verb)
    {
        if (!array_key_exists($path, $this->routes[$verb]))
            return print('Rota não encontrada');

        $controller = $this->routes[$verb][$path];

        $controller();
    }

    public function name() : Route
    {
        // ...

        return $this;
    }
}
