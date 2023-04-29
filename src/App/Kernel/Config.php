<?php

namespace AkemiAdam\Basilisk\App\Kernel;

final class Config
{
    /**
     * Add a new configuration to a JSON file
     * 
     * @param string $settingsPath
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public static function addSetting(string $settingsPath, string $key, mixed $value) : void
    {
        $json = file_get_contents($settingsPath);

        $settings = json_decode($json, true) ?? [];

        $settings[$key] = $value;

        file_put_contents($settingsPath, json_encode($settings));
    }

    /**
     * Returns a specific configuration from a JSON of settings
     * 
     * @param string $settingsPath
     * @param string $key
     * 
     * @return mixed
     */
    public static function getSetting(string $settingsPath, string $key) : mixed
    {
        $json = file_get_contents($settingsPath);

        $settings = json_decode($json, true);

        return $settings[$key];
    }

    /**
     * Returns all settings from a JSON of settings
     * 
     * @param string $settingsPath
     * 
     * @return array
     */
    public static function allSettings(string $settingsPath) : array
    {
        $json = file_get_contents($settingsPath);

        return json_decode($json, true);
    }

    /**
     * Edit a specific configuration from a JSON of settings
     * 
     * @param string $settingsPath
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public static function editSetting(string $settingsPath, string $key, mixed $value) : void
    {
        $settings = self::allSettings($settingsPath);

        $settings[$key] = $value;

        file_put_contents($settingsPath, json_encode($settings));
    }
}