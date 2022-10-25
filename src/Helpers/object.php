<?php

use AkemiAdam\Basilisk\App\Kernel\Config;

/**
 * Takes the object from the file, decodes it and returns the object
 * 
 * @param string $path
 * 
 * @return mixed
 */
function decodeSerealization(string $path) : mixed
{
    $file = file_get_contents($path);

    $object = unserialize($file);

    return $object;
}


/**
 * Serializes the object and saves it to the specified path
 * 
 * @param string $path
 * @param mixed $object
 * 
 * @return void
 */
function encodeSerealization(string $path, mixed $object) : void
{
    $device = serialize($object);

    file_put_contents($path, $device);
}

/**
 * Saves a new configuration to the specific configuration object
 * 
 * @param string $setting
 * @param string $file
 * 
 * @return void
 */
function defineConfig(string $setting, string $file) : void
{
    $path = __DIR__ . '/../Incluides/' . $file;

    if (file_exists($path)) {
        $config = decodeSerealization($paht);
    } else {
        $config = new Config;
    }

    $config->addSetting($setting);
 
    encodeSerealization($path, $config);
}