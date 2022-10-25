<?php

namespace AkemiAdam\Basilisk\App\Console;

use AkemiAdam\Basilisk\App\Kernel\Console;
use AkemiAdam\Basilisk\Exceptions\Database\NoMigrationsCreatedException;

class RunningMigration extends Console
{
    /**
     * Run all migrations
     * 
     * @return void
     */
    public function run() : void
    {
        try {

            $path = root_path() . '/src/Incluides/migrations';

            if (!file_exists($path)) {
                throw new NoMigrationsCreatedException;
            }

        } catch (NoMigrationsCreatedException $e) {
            
            $this->error($e->getMessage());

            exit();
            
        }

        $this->newLine();

        $this->info('Running migrations...');

        $this->newLine();

        require_once \database_path() . '/database.php';

        $this->newLine();
    }
}