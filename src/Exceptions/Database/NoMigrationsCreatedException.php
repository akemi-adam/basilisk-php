<?php

namespace AkemiAdam\Basilisk\Exceptions\Database;

class NoMigrationsCreatedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No migration has been created yet');
    }
}