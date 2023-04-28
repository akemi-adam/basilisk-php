<?php

namespace AkemiAdam\Basilisk\App\Kernel;

final class Config
{
    public static function addSetting(string $settingsPath, string $key, mixed $value) : void
    {
        $json = file_get_contents($settingsPath);

        $settings = json_decode($json, true) ?? [];

        $settings[$key] = $value;

        file_put_contents($settingsPath, json_encode($settings));
    }

    public static function getSetting(string $settingsPath, string $key) : mixed
    {
        $json = file_get_contents($settingsPath);

        $settings = json_decode($json, true);

        return $settings[$key];
    }

    public static function allSettings(string $settingsPath)
    {
        $json = file_get_contents($settingsPath);

        return json_decode($json, true);
    }

    public static function editSetting(string $settingsPath, string $key, mixed $value) : void
    {
        $settings = self::allSettings($settingsPath);

        $settings[$key] = $value;

        file_put_contents($settingsPath, json_encode($settings));
    }
}