<?php
// Enable error reporting during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define the fixed API key
define('API_KEY', '1d99e5708647f2a85298e64126d481a75654e69a2fd26a577d2ab0942a5240a8');

// Retrieve the API key from headers using $_SERVER
$clientApiKey = $_SERVER['HTTP_X_API_KEY'] ?? null;

// Validate the API key
if ($clientApiKey !== API_KEY) {
    http_response_code(403); // Forbidden
    echo json_encode(['error' => 'Invalid or missing API key']);
    exit();
}

// Check if the accountNumber parameter is provided
if (!isset($_GET['accountNumber']) || empty(trim($_GET['accountNumber']))) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Missing or invalid account number']);
    exit();
}

// Sanitize and assign the account number
$accountNumber = strtoupper(trim($_GET['accountNumber']));

// Include the database connection file
include "db.php"; // Ensure this file initializes $db correctly

// SQL query to fetch data for the specific account number
$query = "SELECT TRIM(`BillRefNumber`) AS `BillRefNumber`, `TransAmount`, `TransTime`, `BusinessShortCode`, `TransID`
          FROM `finance`
          WHERE UPPER(TRIM(`BillRefNumber`)) = ?";

$data = []; // Initialize an array to hold the JSON data

if ($stmt = $db->prepare($query)) {
    // Bind the parameter to the query
    $stmt->bind_param("s", $accountNumber);

    // Execute the query
    if ($stmt->execute()) {
        // Bind the result columns
        $stmt->bind_result($billRefNumber, $transAmount, $transTime, $businessShortCode, $transID);

        // Fetch the results and process each row
        while ($stmt->fetch()) {
            $data[] = [
                'BillRefNumber' => $billRefNumber,
                'TransAmount' => $transAmount,
                'TransTime' => $transTime,
                'BusinessShortCode' => $businessShortCode,
                'TransID' => $transID,
            ];
        }

        if (empty($data)) {
            // If no data is found, return zero values
            header('Content-Type: application/json');
            echo json_encode([
                [
                    'BillRefNumber' => $accountNumber,
                    'TransAmount' => 0,
                    'TransTime' => null,
                    'BusinessShortCode' => null,
                    'TransID' => null,
                ]
            ], JSON_PRETTY_PRINT);
        } else {
            // Output the JSON data
            header('Content-Type: application/json');
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Failed to execute the query']);
    }

    // Close the statement
    $stmt->close();
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to prepare the query']);
}

// Close the database connection
$db->close();
?>
