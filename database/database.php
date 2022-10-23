<?php

$migrations = scandir(\database_path() . '/migrations');

foreach ($migrations as $migration) {

    try {
        include \database_path() . "/migrations/$migration";
    } catch (\PDO $e) {
        print($e->getMessage());
    }

}