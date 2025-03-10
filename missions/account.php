<?php
session_start();
print_r($_SESSION);

include 'db.php'; // Include database connection

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://8d21-41-204-187-5.ngrok-free.app/'); // Allow requests from localhost:3000
header('Access-Control-Allow-Methods: POST'); // Allow POST requests
header('Access-Control-Allow-Headers: Content-Type'); // Allow Content-Type header

// Start session

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user ID is set in session
    if(isset($_SESSION['user_id'])) {
        // Retrieve user ID from session
        $user_id = $_SESSION['user_id'];

        // Prepare SQL statement to fetch user account number from the database based on user ID
        $stmt = $db->prepare("SELECT account_no FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Account number found, retrieve it
            $user = $result->fetch_assoc();
            $accountNumber = $user['account_no'];

            // Send the account number as part of the response
            echo json_encode(array("success" => true, "message" => "Account number retrieved", "accountNumber" => $accountNumber));
        } else {
            // Account number not found
            echo json_encode(array("success" => false, "message" => "Account number not found"));
        }

        // Close statement
        $stmt->close();
    } else {
        // User ID not found in session
        echo json_encode(array("success" => false, "message" => "User ID not found in session"));
    }
} else {
    // Handle other request methods if necessary
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
