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
        parent::__construct($args, 3);

        $this->content = <<<EOD
        <?php

        namespace App\Controllers;

        use AkemiAdam\Basilisk\App\Http\Controller;

        class {$this->args[2]} extends Controller
        {

        }

        EOD;
    }

    /**
     * Creates a new controller
     * 
     * @return void
     */
    public function run() : void
    {
        try {

            if (!isset($this->content))
                throw new UndefinedPropertyException;

            $this->newLine();

            $this->writeFile(\app_path() . '/Controllers/' . $this->args[2], $this->content);

            $this->info($this->args[2] . ' controller created with success!');

            $this->newLine();

        } catch (UndefinedPropertyException $e) {
            $this->error($e->getMessage() . ': ' . $this->class() . '::$content');
        }
    }
}