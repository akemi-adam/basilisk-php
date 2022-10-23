<?php

namespace AkemiAdam\Basilisk\Exceptions;

class UndefinedProperty extends \Exception
{
    public function __construct()
    {
        parent::__construct('The property has not yet been defined');
    }
}