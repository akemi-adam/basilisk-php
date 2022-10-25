<?php

namespace AkemiAdam\Basilisk\App\Console\Make;

use AkemiAdam\Basilisk\App\Kernel\Console;
use AkemiAdam\Basilisk\Exceptions\UndefinedPropertyException;
use AkemiAdam\Basilisk\Exceptions\Command\{
    MissingArgumentException
};

class MakeController extends Console
{
    /**
     * Defines the contents of the controller
     * 
     * @param array $args
     * 
     * @return void
     */
    public function __construct(array $args)
    {
        parent::__construct($args);

        try {

            if (!isset($this->args[2])) {

                throw new MissingArgumentException;
            }

            $name = $this->args[2];

            $this->content = "<?php\n\nnamespace App\Controllers;\n\nuse AkemiAdam\Basilisk\App\Http\Controller;\n\nclass $name extends Controller\n{\n\n}";

        } catch (MissingArgumentException $e) {

            $this->error($e->getMessage());

            exit();

        }

    }

    /**
     * Creates a new migration file
     * 
     * @return void
     */
    public function run() : void
    {
        try {

            if (!isset($this->content)) {
                throw new UndefinedPropertyException;
            }

            $this->newLine();

            $this->writeFile(\app_path() . '/Controllers/' . $this->args[2], $this->content);

            $this->info($this->args[2] . ' controller created with success!');

            $this->newLine();

        } catch (UndefinedPropertyException $e) {

            $this->error($e->getMessage() . ': ' . $this->class() . '::$content');

        }
    }
}