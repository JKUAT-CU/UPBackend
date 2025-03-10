<?php
// Enable error reporting for debugging (disable in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include necessary files
include "../../backend/db.php"; // Ensure $mysqli is properly initialized here
include "../session.php"; // Manages session start and user authentication

// Retrieve user ID from session
$user_id = $_SESSION['user_id'];

try {
    // Prepare SQL to fetch image path for the logged-in user
    $userSql = "SELECT images FROM UP WHERE id = ?";
    $stmt = $mysqli->prepare($userSql);  // Use $mysqli instead of $conn

    if (!$stmt) {
        throw new Exception("Prepared statement creation failed: " . $mysqli->error);
    }

    // Bind user_id and execute query
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Bind result variable and fetch the result
    $stmt->bind_result($image_path);
    if ($stmt->fetch()) {
        // Include appropriate script based on image presence
        if (!empty($image_path)) {
            include 'download.php'; // User has uploaded an image
        } else {
            include 'script.php'; // No image uploaded
        }
    } else {
        echo "No results found for user ID: $user_id";
    }

    // Close the prepared statement
    $stmt->close();

} catch (Exception $e) {
    // Log errors and display a generic message
    error_log("Error: " . $e->getMessage());
    echo "An unexpected error occurred. Please try again later.";
} finally {
    // Close the database connection
    if ($mysqli) {
        $mysqli->close();  // Use $mysqli to close the connection
    }
}
?>
