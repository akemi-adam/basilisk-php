<?php

namespace AkemiAdam\Basilisk\Exceptions;

class ServiceNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The service could not be found.');
    }
}