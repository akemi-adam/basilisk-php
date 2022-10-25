<?php

require __DIR__ . '/app.php';

/*
|--------------------------------------------------------------------------
| Viper
|--------------------------------------------------------------------------
|
| Viper is the command manager for Basilisk cli. From a simple and easy-to-remember syntax, it is possible to execute
| several commands to facilitate application development.
|
| The syntax always starts with prefixes: 'php viper', followed by the name of the command and, optionally, some option
| or argument that the command takes.
|
| Here is an example: php viper server
|
*/

$commands = require __DIR__ . '/config/console.php';

if (array_key_exists($argv[1], $commands)) {

    $console = new $commands[$argv[1]]($argv);

    $console->run();

}