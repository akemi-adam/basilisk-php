<?php

/**
 * Returns the root directory path
 * 
 * @return string
 */
function root_path() : string
{
    return __DIR__ . '/../..';
}

/**
 * Returns the database path
 * 
 * @return string
 */
function database_path() : string
{
    return root_path() . '/database';
}

/**
 * Returns the config path
 * 
 * @return string
 */
function config_path() : string
{
    return root_path() . '/config';
}

/**
 * Returns the resource path
 * 
 * @return string
 */
function resource_path() : string
{
    return root_path() . '/resource';
}

/**
 * Returns the views path
 * 
 * @return string
 */
function views_path() : string
{
    return resource_path() . '/views';
}

/**
 * Returns the routes path
 * 
 * @return string
 */
function routes_path() : string
{
    return root_path() . '/routes';
}

/**
 * Returns the app path
 * 
 * @return string
 */
function app_path() : string
{
    return root_path() . '/app';
}

/**
 * Returns the includes path
 * 
 * @return string
 */
function includes_path() : string
{
    return root_path() . '/incluides';
}