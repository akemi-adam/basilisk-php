<?php

use AkemiAdam\Basilisk\App\Kernel\Route;

$route = new Route;

$route->get('/', '/dashboard')->name('dashboard', 'get');

return $route;