<?php

namespace AkemiAdam\Basilisk\App\Kernel;

final class Config
{
    private array $settings;

    /**
     * Initializes the $settings attribute like a array
     * 
     * @return void
     */
    public function __construct()
    {
        $this->settings = array();
    }

    /**
     * Add a setting to the $settings attribute
     * 
     * @param mixed $setting
     * 
     * @return void
     */
    public function addSetting(mixed $setting) : void
    {
        $this->settings[] = $setting;
    }

    /**
     * Returns the all settings
     * 
     * @return array
     */
    public function allSettings() : array
    {
        return $this->settings;
    }

    /**
     * Returns the a specific setting from the $settings attribute
     * 
     * @param mixed $key
     * 
     * @return mixed
     */
    public function getSetting(mixed $key) : mixed
    {
        return $this->settings[$key];
    }
}