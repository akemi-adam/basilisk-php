<?php

namespace AkemiAdam\Basilisk\App\Kernel;

class Bootstrap
{
    protected $router;

    public function __construct(Route $router)
    {
        $this->router = $router;
    }

    public function boot() : void
    {
        $this->router->boot();
    }
}