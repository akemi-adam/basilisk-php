<?php

namespace AkemiAdam\Basilisk\App\Console;

use AkemiAdam\Basilisk\App\Kernel\Console;

class Server extends Console
{
    /**
     * Start the server
     * 
     * @return void
     */
    public function run() : void
    {
        $this->newLine();

        $this->info('Starting the server...');

        $this->newLine();

        shell_exec('php -S localhost:8000');
    }
}