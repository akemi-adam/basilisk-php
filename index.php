<?php

require __DIR__ . '/app.php';

use AkemiAdam\Basilisk\App\Kernel\Bootstrap;

$app = new Bootstrap(require_once __DIR__ . '/routes/web.php');

$app->boot();