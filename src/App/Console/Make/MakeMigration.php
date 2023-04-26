<?php

namespace AkemiAdam\Basilisk\App\Console\Make;

use AkemiAdam\Basilisk\Exceptions\Command\MissingArgumentException;
use AkemiAdam\Basilisk\Exceptions\UndefinedPropertyException;
use AkemiAdam\Basilisk\App\Kernel\{
    Console, Config
};


class MakeMigration extends Console
{
    /**
     * Defines the contents of the migration
     * 
     * @param array $args
     * 
     * @return void
     */
    public function __construct(array $args)
    {
        parent::__construct($args, 3);

        $table = explode('_', $this->args[2])[1];

        $this->content = <<<EOD
        <?php

        use AkemiAdam\Basilisk\Database\Migration;

        \$table = new Migration('$table');

        \$table->id();



        \$table->run();

        EOD;
    }

    /**
     * Creates a new migration file
     * 
     * @return void
     */
    public function run() : void
    {
        try {

            if (!isset($this->content))
                throw new UndefinedPropertyException;

            $this->newLine();

            $migration = now() . '_' . $this->args[2];

            $this->writeFile(\database_path() . "/migrations/$migration", $this->content);

            defineConfig($migration, 'migrations');

            $this->info("$migration migration created with success!");

            $this->newLine();

        } catch (UndefinedPropertyException $e) {

            $this->error($e->getMessage() . ': ' . $this->class() . '::$content');

        }
    }
}