<?php

use Faker\Generator;
use Faker\Factory;


/*
 * Returns a instace of object faker for seeder and tests
 *
 * @param string $lanaguage = 'pt_BR'
 *
 * @return Generator
 *
 */
function faker(string $language = 'pt_BR') : Generator
{
    return Factory::create($language);
}

/**
 * Verify if value is a string and if this is true, then returns the value with quotes
 * 
 * @param mixed $value
 * 
 * @return mixed
 */
function isString(mixed $value) : mixed
{
    return \gettype($value) == 'string' ? "'$value'" : $value;
}

/*
 * Get all dynamics (and publics) properties from a object
 *
 * @param object $object
 */
function get_dynamics_properties(object $object) : array
{
    return get_object_vars($object);
}

/*
 * Read a file line by line
 *
 * @param $file_path
 *
 * @return \Generator
 */
function read_file(string $file_path) : \Generator
{
    $file = fopen($file_path, 'r');

    while (!feof($file))
        yield fgets($file);
}

