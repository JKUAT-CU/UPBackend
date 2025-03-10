<?php
// Enable error reporting (for debugging during development)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// API Key constant
define('API_KEY', '1d99e5708647f2a85298e64126d481a75654e69a2fd26a577d2ab0942a5240a8');

// Include database connection
include "../../backend/db.php"; // Ensure this file initializes the $mysqli object
include "../session.php";

// Fetch logged-in user ID
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}
$user_id = $_SESSION['user_id'];


// Handle GET request for fetching user and mission details
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userQuery = $mysqli->prepare("SELECT account_number FROM UP WHERE id = ?");
    $userQuery->bind_param("s", $user_id);
    $userQuery->execute();
    $userQuery->bind_result($accountNumber);

    if (!$userQuery->fetch()) {
        die("No account details found for this user.");
    }

 ;

    // Fetch contributions data from API
    $apiUrl = "https://portal.jkuatcu.org/missions/pages/api.php?accountNumber=" . urlencode($accountNumber);
    $options = [
        "http" => [
            "header" => "X-API-KEY: " . API_KEY
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    $totalAmount = 0; // Default total amount raised
    if ($response !== false) {
        $data = json_decode($response, true);

        if (!empty($data)) {
            foreach ($data as $entry) {
                $normalizedAccountNumber = strtoupper(preg_replace('/\s+/', '', $accountNumber));
                $normalizedBillRefNumber = strtoupper(preg_replace('/\s+/', '', $entry['BillRefNumber']));

                if ($normalizedBillRefNumber === $normalizedAccountNumber) {
                    $totalAmount += $entry['TransAmount'];
                }
            }
        }
    } else {
        die("Error fetching API data.");
    }

    // Render the HTML page
    include "template/dashboard.php"; // Move the HTML to a separate file for clarity
    exit();
}

// Fallback for unsupported methods
echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
exit();
?>
