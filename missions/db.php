<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'jkuatcu_daraja'); // Change this to your actual database username
define('DB_PASSWORD', 'K@^;daY0*j(n'); // Change this to your actual database password
define('DB_NAME', 'jkuatcu_daraja');

try {
    // Create a connection to the database
    $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check if the connection was successful
    if ($db->connect_error) {
        // Log the error
        error_log("Connection failed: " . $db->connect_error);
        
        // Display a user-friendly error message
        die("An error occurred while connecting to the database. Please try again later.");
    }

    // You might want to set the character set here if needed
    // $db->set_charset("utf8mb4");

} catch (Exception $e) {
    // Log the error
    error_log("Error: " . $e->getMessage());
    
    // Display a user-friendly error message
    die("An unexpected error occurred. Please try again later.");
}
?>
