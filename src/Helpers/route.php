<?php

use AkemiAdam\Basilisk\App\Kernel\Route;
use AkemiAdam\Basilisk\Exceptions\FileNotFoundException;

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
 * 
 * @return void
 */
function view(string $path) : void
{
    $filename = views_path() . '/' . str_replace('.', '/', $path) . '.php';

    try {

        if (!file_exists($filename))
            throw new FileNotFoundException;
    
        include $filename;

    } catch (FileNotFoundException $e) {

        print($e->getMessage());

        exit(1);
    }
}