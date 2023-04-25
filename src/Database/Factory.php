<?php

namespace AkemiAdam\Basilisk\Database;

trait Factory
{
    private static $connection;

    public function __construct()
    {
        $this->connection = get_connection();
    }

    public static function create(array $data) : void
    {

    }
}