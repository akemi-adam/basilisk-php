<?php

use AkemiAdam\Basilisk\App\Kernel\{
    Bootstrap, Container, Route
};

uses()->group('bootstrap');

$app = new Bootstrap(
    require_once __DIR__ . '/../../config/services.php',
    require_once __DIR__ . '/../../routes/web.php',
);

it('has the route and container properties', fn () => expect($app)->toHaveProperties([ 'router', 'container' ]));

it('has the boot and resolve methods', fn () => expect($app)->toHaveMethods([ 'boot', 'resolve' ]));