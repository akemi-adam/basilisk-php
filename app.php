<?php

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/src/Helpers/helper.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->load();