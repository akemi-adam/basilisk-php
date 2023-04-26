<?php

use AkemiAdam\Basilisk\App\Console\{
    RunningMigration, Server
};

use AkemiAdam\Basilisk\App\Console\Make\{
    MakeMigration, MakeModel, MakeController
};


return [
    'server' => Server::class,
    'migrate' => RunningMigration::class,
    'make:controller' => MakeController::class,
    'make:migration' => MakeMigration::class,
    'make:model' => MakeModel::class,
];