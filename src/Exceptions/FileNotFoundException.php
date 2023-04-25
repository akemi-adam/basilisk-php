<?php

namespace AkemiAdam\Basilisk\Exceptions;

class FileNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('The file could not be found. Check the path or file name.');
    }
}