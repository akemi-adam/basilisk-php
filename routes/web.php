<?php

use AkemiAdam\Basilisk\App\Kernel\Route;
use App\Controllers\UserController;

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
| Examples:
|
| $router->get('/', function () => { return view('dashboard'); });
|
| Or
|
| $router->get('/', [HomepageController::class, 'index']);
|
*/

$route->get('/', function ()
{
    return view('basilisk');
});



return $route;