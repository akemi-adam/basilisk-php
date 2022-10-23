<?php

namespace AkemiAdam\Basilisk\App\Console\Make;

use AkemiAdam\Basilisk\App\Kernel\Console;
use AkemiAdam\Basilisk\Exceptions\UndefinedProperty;
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
        parent::__construct($args);

        try {

            if (!isset($this->args[2])) {

                throw new MissingArgumentException;
            }

            $header = "<?php\n\nnamespace App\Models;\n\nuse AkemiAdam\Basilisk\App\Models\Model;\n\n";

            $scope = "class " . $this->args[2] . " extends Model \n{\n\n}";

            $this->content = $header . $scope;

        } catch (MissingArgumentException $e) {

            $this->error($e->getMessage());

            exit();

        }

    }

    /**
     * Creates a new model file
     * 
     * @return void
     */
    public function run() : void
    {
        try {

            if (!isset($this->content)) {
                throw new UndefinedProperty;
            }

            $this->newLine();

            $this->writeFile(\app_path() . '/Models/' . $this->args[2], $this->content);

            $this->info($this->args[2] . ' model created with success!');

            $this->newLine();

        } catch (UndefinedProperty $e) {

            $this->error($e->getMessage() . ': ' . $this->class() . '::$content');

        }
    }
}