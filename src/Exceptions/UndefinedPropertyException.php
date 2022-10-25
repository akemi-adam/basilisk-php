<?php

namespace AkemiAdam\Basilisk\Exceptions;

class UndefinedPropertyException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The property has not yet been defined');
    }
}