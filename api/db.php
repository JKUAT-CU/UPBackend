<?php
// Default database credentials (same for all databases)
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'jkuatcu_devs');
define('DB_PASSWORD', '#God@isAble!#');

/**
 * Get a database connection dynamically.
 *
 * @param string $dbName The name of the database to connect to.
 * @return mysqli The database connection.
 * @throws Exception If connection fails.
 */
function getDatabaseConnection($dbName) {
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, $dbName);

    if ($mysqli->connect_error) {
        throw new Exception("Connection to database '{$dbName}' failed: " . $mysqli->connect_error);
    }

    return $mysqli;
}
?>
