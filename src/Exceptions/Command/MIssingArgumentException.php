<?php

namespace AkemiAdam\Basilisk\Exceptions\Command;

class MissingArgumentException extends \Exception
{
    public function __construct()
    {
        parent::__construct('An argument is missing in the command');
    }
}