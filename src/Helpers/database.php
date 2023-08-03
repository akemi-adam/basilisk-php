<?php

/**
 * Returns the connection of database
 * 
 * @return PDO
 */
function get_connection() : \PDO
{
    return require config_path() . '/connection.php';
}
