<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['api_key'])) {
    session_unset();
    session_destroy();
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['error' => 'User not logged in. Please login.']);
    exit;
}
?>
