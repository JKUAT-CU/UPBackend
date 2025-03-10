<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: ../../login.php");
    exit(); // Stop executing the current script
}
?>
