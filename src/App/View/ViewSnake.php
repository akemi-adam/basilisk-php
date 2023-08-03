<?php

namespace AkemiAdam\Basilisk\App\View;

use AkemiAdam\Basilisk\App\Kernel\Config;


class ViewSnake
{
    private string $path;

    public function __construct(string $path = '')
    {
        $this->path = $path ?: views_path();
    }

    /**
     * Renders a view
     * 
     * @param string $filename
     * @param array $data
     * 
     * @return void
     */
    public function render(string $filename, array $data = [])
    {
        foreach ($data as $key => $value) ${$key} = $value;

        $viewPath = \storage_path() . '/views';

        $originalFile = "{$this->path}/$filename";

        $configPath = "$viewPath/views.json";
        
        // Checks if the template exists and if it has been modified
        if ($view = Config::getSetting($configPath, $filename))
        {
            if (!$this->fileWasModified($originalFile, "$viewPath/$view.php"))
            {
                include "$viewPath/$view.php";

                exit;
            }

            unlink("$viewPath/$view.php");
        }

        $newFilename = md5($originalFile);

        $file = fopen("$viewPath/$newFilename.php", 'w');

        Config::addSetting($configPath, $filename, $newFilename);

        $this->make($originalFile, $file);

        fclose($file);

        include "$viewPath/$newFilename.php";
    }

    /**
     * Checks if a file been was modified
     * 
     * @param string $originalFile
     * @param string $newFile
     * 
     * @return bool
     */
    private function fileWasModified(string $originalFile, string $newFile) : bool
    {
        $originalContents = file_get_contents($originalFile);
        
        $newContents = str_replace(['<?=', '?>'], ['{{', '}}'], file_get_contents($newFile));

        return $originalContents !== $newContents;
    }

    /**
     * Reads the template file line by line and defines the data and the logic
     * 
     * @param $originalFile
     * @param $file
     * 
     * @return void
     */
    private function make(string $originalFile, $file) : void
    {
        foreach (\read_file($originalFile) as $line)
        {
            if (preg_match('/{{|}}/', $line))
                $this->setData($line);

            if (preg_match('/@/', $line))
            {
                $this->setBlock('if', $line, function (string &$line) {
                    if (preg_match('/@elseif\(.*\)/', $line)) {
                        $line = preg_replace('/@/', '<?php ', $line);
                        $line = preg_replace('/elseif\((.*?)\)/', 'elseif ($1): ?>', $line);
                    }

                    if (preg_match('/@else/', $line))
                        $line = str_replace('@else', '<?php else: ?>', $line);
                });

                $this->setBlock('foreach', $line);
                
                $this->setBlock('for', $line);
            }

            fputs($file, $line);
        }
    }

    /**
     * Defines a data in the template to be shown
     * 
     * @param string &$line
     * 
     * @return void
     */
    private function setData(string &$line) : void
    {
        $line = str_replace([ '{{', '}}' ], [ '<?=', '?>' ], $line);
    }

    /**
     * Defines logic struct in the template
     * 
     * @param string &$line
     * 
     * @return void
     */
    private function setBlock(string $struct, string &$line, ?\Closure $othersChecks = null)
    {
        if (preg_match("/@$struct\(.*\)/", $line))
        {
            $line = preg_replace("/@/", "<?php ", $line);

            $line = preg_replace("/$struct\((.*?)\)/", "$struct ($1): ?>", $line);
        }

        if ($othersChecks) $othersChecks($line);

        if (preg_match("/@end$struct/", $line))
            $line = str_replace("@end$struct", "<?php end$struct; ?>", $line);
    }
}
