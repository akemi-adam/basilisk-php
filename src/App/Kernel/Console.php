<?php

namespace AkemiAdam\Basilisk\App\Kernel;

abstract class Console
{
    use Base;

    protected string $content;

    protected array $args;

    public function __construct(array $args) {
        $this->args = $args;
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