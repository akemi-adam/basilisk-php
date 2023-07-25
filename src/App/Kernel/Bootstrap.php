<?php

namespace AkemiAdam\Basilisk\App\Kernel;

class Bootstrap
{
    private Route $router;

    private Container $container;

    public function __construct(Container $container, Route $router)
    {
        $this->container = $container;

        $this->router = $router;
    }

    public function boot() : void
    {
        $this->router->boot();
    }

    public function resolve(string $service) : Object
    {
        return $this->container->resolve($service);
    }
}