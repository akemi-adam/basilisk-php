<?php

use AkemiAdam\Basilisk\Database\Migration;

$table = new Migration('users');

$table->id();

$table->string('username', 255);

$table->string('email', 255);

$table->boolean('admin');

$table->unique([
    'email'
]);

$table->notNull([
    'username',
    'email',
]);

$table->default([
    'admin' => 0,
]);

$table->run();