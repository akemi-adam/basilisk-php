<?php

namespace AkemiAdam\Basilisk\App\Console;

use AkemiAdam\Basilisk\Exceptions\Database\NoMigrationsCreatedException;
use AkemiAdam\Basilisk\App\Kernel\{
    Console, Config
};

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

            $path = \database_path() . '/migrations';

            if (!file_exists($path))
                throw new NoMigrationsCreatedException;

        } catch (NoMigrationsCreatedException $e) {
            
            $this->error($e->getMessage());

            exit();

        }

        $this->newLine();

        $this->info('Running migrations...');

        $this->newLine();

        $path = \database_path() . '/migrations.json';

        foreach (Config::allSettings($path) as $migration => $running)
        {
            try {
                
                if (!$running)
                {
                    Config::editSetting($path, $migration, true);

                    include \database_path() . "/migrations/$migration.php";

                    $this->info("$migration run successfully");
                }

            } catch (\PDO $e) {
                $this->error($e->getMessage());
            }
        }

        $this->newLine();
    }
}