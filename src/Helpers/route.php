<?php

use AkemiAdam\Basilisk\App\Kernel\Route;

/**
 * Returns the routes of web.php file
 * 
 * @return Route
 */
function web() : Route
{
    $router = require routes_path() . '/web.php';

    return $router;
}

/**
 * Returns a route path by name 
 * 
 * @param string $name
 * 
 * @return string
 */
function route(string $name) : string
{
    $router = web();
    
    return array_key_exists($name, $router->getRoutes()) ? $router->getRoute($name) : false;
}

/**
 * Send to a route
 * 
 * @param string $path
 * @param string $method
 */
function view(string $path, array $method) : void
{
    if (array_key_exists($path, $method)) {

        include(views_path() . $method[$path] . '.php');

        exit;
    }

    include(views_path() . route('error.404') . '.php');
}