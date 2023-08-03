<?php

namespace AkemiAdam\Basilisk\Exceptions\Database;

class CollumnNotFoundInTheTableException extends \Exception
{
    public function __construct(string $table)
    {
        parent::__construct('The collumn could not be found in the table ' . $table);
    }
}
