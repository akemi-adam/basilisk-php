<?php

use AkemiAdam\Basilisk\Kernel\Config;



$object = file_get_contents($path);

$config = unserialize($object);

$migrations = $config->allSettings();

foreach ($migrations as $migration)
{
    try {
        
        include \database_path() . "/migrations/$migration.php";

        $this->info("$migration run successfully");

    } catch (\PDO $e) {
        print($e->getMessage());
    }
}