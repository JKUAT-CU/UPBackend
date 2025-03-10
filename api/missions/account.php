<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../cors.php";
include '../db.php'; 
include '../session.php'; 

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Check if session is being set properly
error_log("Current Session ID: " . session_id());
error_log("Session User ID: " . ($_SESSION['user_id'] ?? 'Not Set'));

// Verify if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['hasAccount' => false, 'message' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Connect to the database
    $db = getDatabaseConnection('jkuatcu_data');

    // Prepare a query to check if the user already has an account
    $query = "SELECT account_number FROM makueni WHERE member_id = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        echo json_encode(['hasAccount' => false, 'message' => 'Failed to prepare query.']);
        exit;
    }

    $stmt->bind_param("s", $userId); // "s" for string type
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User has an account
        echo json_encode(['hasAccount' => true]);
    } else {
        // User does not have an account
        echo json_encode(['hasAccount' => false]);
    }

    // Close resources
    $stmt->close();
    $db->close();
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage()); // Log error without exposing details
    echo json_encode(['hasAccount' => false, 'message' => 'Database error occurred.']);
}
?>
