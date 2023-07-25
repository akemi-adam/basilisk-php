<?php

namespace AkemiAdam\Basilisk\App\Kernel;

class Route
{
    protected array $routes;

    protected string $currentRoute;

    public function __construct()
    {
        $this->routes = ['GET' => [], 'POST' => []];
    }

    /**
     * Sets a route to the array $this->routes separating by its HTTP verb
     * 
     * @param string $path
     * @param string $verb
     * @param \Closure|array $controller
     * 
     * @return void
     */
    protected function createRoute(string $path, string $verb, \Closure|array $controller) : void
    {
        $this->routes[$verb] += [$path => $controller];

        $this->currentRoute = $path;
    }

    /**
     * Defines a GET route
     * 
     * @param string $path
     * @param \Closure|array $controller
     * 
     * @return Route
     */
    public function get(string $path, \Closure|array $controller) : Route
    {
        $this->createRoute($path, 'GET', $controller);

        return $this;
    }

    /**
     * Defines a POST route
     * 
     * @param string $path
     * @param \Closure|array $controller
     * 
     * @return Route
     */
    public function post(string $path, \Closure|array $controller) : Route
    {
        $this->createRoute($path, 'POST', $controller);

        return $this;
    }

    /**
     * Checks the route path and the request method to perform an action
     * 
     * @return void
     */
    public function boot() : void
    {
        $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST')
            $this->send($path, 'POST');
        
        else if ($method === 'GET')
            $this->send($path, 'GET');
    }

    /**
     * Checks if the route exists and if so, whether the action is per controller or per Closure. At the end, it executes the function that acts as a controllator
     * 
     * @param string $path
     * @param string $verb
     */
    protected function send(string $path, string $verb)
    {
        if (!array_key_exists($path, $this->routes[$verb]))
            return print('Rota não encontrada');

        $actions = $this->routes[$verb][$path];

        if (is_array($actions))
        {
            $controller = new $actions[0];

            $controller->{$actions[1]}();

            return;
        }

        $actions();
    }

    public function name() : Route
    {
        // ...

        return $this;
    }
}
