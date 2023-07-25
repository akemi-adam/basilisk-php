<?php

use AkemiAdam\Basilisk\App\Kernel\Container;

uses()->group('container');

$container = new Container;

it('has the bindings property', fn () => expect($container)->toHaveProperty('bindings'));

it('has the bind and resolve methods', fn () => expect($container)->toHaveMethods([ 'bind', 'resolve' ]));