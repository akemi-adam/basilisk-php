<?php

/**
 * Returns the connection of database
 * 
 * @return PDO
 */
function get_connection()
{
    return config_path() . '/connection.php';
}