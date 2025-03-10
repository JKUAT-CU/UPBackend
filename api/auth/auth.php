<?php
session_start();
require "../cors.php";

header("Content-Type: application/json");

// Get API key from request headers
$headers = getallheaders();
$providedApiKey = isset($headers['Authorization']) ? trim(str_replace('Bearer ', '', $headers['Authorization'])) : '';

if (!isset($_SESSION['api_key']) || $_SESSION['api_key'] !== $providedApiKey) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized. Please log in again.']);
    exit;
}

// Reset session timeout
$_SESSION['last_activity'] = time();
?>
