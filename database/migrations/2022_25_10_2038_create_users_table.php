<?php

use AkemiAdam\Basilisk\Database\Migration;

$table = new Migration('users');

$table->id();

$table->string('first_name');

$table->string('email');

$table->string('password');

$table->run();
