<?php

use AkemiAdam\Basilisk\App\Kernel\Route;

$route = new Route;

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| This is where you can define the routes of your application.
|
| To do this, simply call one of the HTTP verbs (get and post) from the $router object and
| pass the path and callback as arguments.
|
| Example:
|
| $router->get('/', function () => { return view('dashboard'); });
|
*/

$route->get('/', function ()
{
    return view('basilisk');
});

return $route;