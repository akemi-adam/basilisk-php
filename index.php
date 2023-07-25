<?php

require __DIR__ . '/app.php';

$app = new AkemiAdam\Basilisk\App\Kernel\Bootstrap(
    require_once __DIR__ . '/config/services.php',
    require_once __DIR__ . '/routes/web.php',
);

$app->boot();