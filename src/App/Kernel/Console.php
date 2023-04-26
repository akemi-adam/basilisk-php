<?php

namespace AkemiAdam\Basilisk\App\Kernel;

use AkemiAdam\Basilisk\Exceptions\Command\MissingArgumentException;

abstract class Console
{
    protected string $content;

    protected array $args;

    protected int $expectedRequiredArgs;

    public function __construct(array $args, int $expectedRequiredArgs = 2)
    {
        try {
    
            if (count($args) !== $expectedRequiredArgs)
                throw new MissingArgumentException;

            $this->args = $args;

            $this->expectedRequiredArgs = $expectedRequiredArgs;
    
        } catch (MissingArgumentException $e) {

            $this->error($e->getMessage());

            exit();

        }
    }

    abstract public function run() : void;

    /**
     * Informs a message
     * 
     * @param string $message
     * 
     * @return void
     */
    protected function info(string $message) : void
    {
        print("\e[0;32m$message\e[0m\n");
    }

    /**
     * Ask a question and return it
     * 
     * @param string $question
     * 
     * @return mixed
     */
    protected function ask(string $question) : mixed
    {
        return readline("\e[0;32m$question\e[0m\n");
    }

    /**
     * Returns a error message
     * 
     * @param string $message
     * 
     * @return void
     */
    protected function error(string $message) : void
    {
        print("\e[0;31m$message\e[0m\n");
    }

    /**
     * Adds a line break
     * 
     * @return void
     */
    protected function newLine() : void
    {
        print("\n");
    }

    /**
     * Write a new file .php
     * 
     * @param string $name
     * @param string $content
     * 
     * @return void
     */
    protected function writeFile(string $name, string $content) : void
    {
        file_put_contents("$name.php", $content);
    }
}