<?php

use AkemiAdam\Basilisk\Exceptions\FileNotFoundException;
use AkemiAdam\Basilisk\App\View\ViewSnake;
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
 * 
 * @return void
 */
function view(string $path, array $data = [])
{
    $filename = str_replace('.', '/', $path) . '.html';

    try {

        if (!file_exists(views_path() . '/' . $filename))
            throw new FileNotFoundException;

        $template = new ViewSnake;

        $template->render($filename, $data);

    } catch (FileNotFoundException $e) {

        print($e->getMessage());

        exit(1);
    }
}