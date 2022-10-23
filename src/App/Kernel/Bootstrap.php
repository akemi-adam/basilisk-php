<?php

namespace AkemiAdam\Basilisk\App\Kernel;

use AkemiAdam\Basilisk\App\Kernel\Route;

class Bootstrap
{
    use Base;
    
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