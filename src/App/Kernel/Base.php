<?php

namespace AkemiAdam\Basilisk\App\Kernel;

trait Base
{
    public static $class;

    public function __construct() {
        self::$class = \get_class($this);
    }
    
}