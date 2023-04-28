<?php

namespace AkemiAdam\Basilisk\App\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewSnake
{
    private Environment $twig;

    public function __construct(string $path = '')
    {
        $path = $path ?: views_path();

        $this->twig = new Environment(new FilesystemLoader($path));
    }

    /**
     * Renders a view
     * 
     * @param string $filename
     * @param array $data
     * 
     * @return void
     */
    public function render(string $filename, array $data = []) : void
    {
        echo $this->twig->render($filename, $data);
    }
}