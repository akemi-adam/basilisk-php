<?php

namespace AkemiAdam\Basilisk\App\Console;

use AkemiAdam\Basilisk\App\Kernel\Console;

class RunningMigration extends Console
{
    /**
     * Run all migrations
     * 
     * @return void
     */
    public function run() : void
    {
        $this->newLine();

        $this->info('Running migrations...');
        
        require_once \database_path() . '/migrations/migrate.php';
    }
}