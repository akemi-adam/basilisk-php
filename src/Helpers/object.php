<?php

use AkemiAdam\Basilisk\App\Kernel\Config;

function defineConfig(string $migration, string $file) : void
{
    $path = __DIR__ . '/../Incluides/' . $file;

    if (file_exists($path)) {

        $file = \file_get_contents($path);

        $config = \unserialize($file);

    } else {

        $config = new Config;
    
    }

    $config->addSetting($migration);

    $object = \serialize($config);

    file_put_contents($path, $object);
}