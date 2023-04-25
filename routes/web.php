<?php

use AkemiAdam\Basilisk\App\Kernel\Route;

$route = new Route;


$route->get('/', function ()
{
    return view('basilisk');
});

return $route;