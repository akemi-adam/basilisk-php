<?php

namespace AkemiAdam\Basilisk\App\Kernel;

use AkemiAdam\Basilisk\Exceptions\ServiceNotFoundException;

class Container
{
    private array $bindings = [];

    public function bind(string $service, \Closure $binding) : void
    {
        $this->bindings[$service] = $binding;
    }

    public function resolve(string $service) : Object
    {
        if (!array_key_exists($service, $this->bindings))
            throw new ServiceNotFoundException;
        
        return $this->bindings[$service]();
    }
}