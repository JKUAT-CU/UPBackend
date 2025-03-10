<?php
// Allow requests from localhost:5173 (Vite default dev server)
header("Access-Control-Allow-Origin: http://localhost:4173");

// Allow common HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Allow credentials (if needed)
header("Access-Control-Allow-Credentials: true");

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
?>
