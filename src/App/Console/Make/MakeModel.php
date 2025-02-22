<?php

namespace AkemiAdam\Basilisk\App\Console\Make;

use AkemiAdam\Basilisk\App\Kernel\Console;
use AkemiAdam\Basilisk\Exceptions\UndefinedPropertyException;
use AkemiAdam\Basilisk\Exceptions\Command\{
    MissingArgumentException
};

class MakeModel extends Console
{
    /**
     * Defines the contents of the model
     * 
     * @param array $args
     * 
     * @return void
     */
    public function __construct(array $args)
    {
        parent::__construct($args, 3);

        $this->content = <<<EOD
        <?php

        namespace App\Models;

        use AkemiAdam\Basilisk\App\Komodo\Model;

        class {$this->args[2]} extends Model
        {

        }

        EOD;
    }

    /**
     * Creates a new model file
     * 
     * @return void
     */
    public function run() : void
    {
        try {

            if (!isset($this->content))
                throw new UndefinedPropertyException;

            $this->newLine();

            $this->writeFile(\app_path() . '/Models/' . $this->args[2], $this->content);

            $this->info($this->args[2] . ' model created with success!');

            $this->newLine();

        } catch (UndefinedPropertyException $e) {

            $this->error($e->getMessage() . ': ' . $this->class() . '::$content');

        }
    }
}