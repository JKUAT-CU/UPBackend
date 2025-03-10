<?php
session_start(); // Ensure session is started

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => true,
        'user_id' => $_SESSION['user_id'],
        'api_key' => $_SESSION['api_key'] ?? 'Not Set'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'User not logged in'
    ]);
}
?>
