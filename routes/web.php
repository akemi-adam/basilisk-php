<?php

use AkemiAdam\Basilisk\App\Kernel\Route;
use App\Controllers\UserController;
use App\Controllers\TestController;


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
| $router->get('/', fn () => view('dashboard'));
|
| Or
|
| $router->get('/', [HomepageController::class, 'index']);
|
*/

$route->get('/', function ()
{
    return view('basilisk', [
        'name' => 'Akemi Adam',
    ]);
});


return $route;
