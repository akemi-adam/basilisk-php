<?php

use AkemiAdam\Basilisk\Database\Migration;

$table = new Migration('users');

$table->id();

$table->run();

