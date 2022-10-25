<?php

use AkemiAdam\Basilisk\Kernel\Config;

$config = decodeSerealization($path);

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