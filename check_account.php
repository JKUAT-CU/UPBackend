<?php
include 'backend/db.php'; // Include the database connection file

// Check for database connection error
if ($mysqli->connect_error) {
    echo json_encode(['hasAccount' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verify if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['hasAccount' => false, 'message' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];

// Prepare a query to check if the user already has an account
$query = "SELECT account_number FROM makueni WHERE member_id = ?";
$stmt = $mysqli->prepare($query);

if (!$stmt) {
    echo json_encode(['hasAccount' => false, 'message' => 'Failed to prepare query.']);
    exit;
}

$stmt->bind_param("s", $userId); // Use "s" for string type as member_id is likely a string
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // User has an account
    echo json_encode(['hasAccount' => true]);
} else {
    // User does not have an account
    echo json_encode(['hasAccount' => false]);
}

// Clean up resources
$stmt->close();
$mysqli->close();
?>
