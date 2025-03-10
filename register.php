<?php
session_start();
include "session.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if ($input['action'] === 'register') {
        // Database connection (update with your credentials)
        $db = new mysqli('localhost', 'jkuatcu_devs', '#God@isAble!#', 'jkuatcu_data');

        if ($db->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
            exit;
        }

        // Get user ID from session
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Check if user already has an account
        $checkQuery = "SELECT account_number FROM UP WHERE id = ?";
        $stmt = $db->prepare($checkQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // User already has an account
            $stmt->close();
            $db->close();
            echo json_encode(['success' => false, 'message' => 'Account already exists.']);
            exit;
        }
        $stmt->close();

        // Function to generate a unique account number
        function generateAccountNumber($db) {
            $prefix = "MM";
            $randomNumber = str_pad(mt_rand(1, 999), 3, "0", STR_PAD_LEFT); // Generate random number between 001 and 999
            $accountNumber = $prefix . $randomNumber;

            // Check if the generated number is already in use
            $checkQuery = "SELECT id FROM makueni WHERE account_number = ?";
            $stmt = $db->prepare($checkQuery);
            $stmt->bind_param("s", $accountNumber);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->close();
                return generateAccountNumber($db);
            }

            $stmt->close();
            return $accountNumber;
        }

        $accountNumber = generateAccountNumber($db);

        // Insert account into `makueni` table
        $insertQuery = "INSERT INTO makueni (account_number, member_id) VALUES (?, ?)";
        $stmt = $db->prepare($insertQuery);
        $stmt->bind_param("si", $accountNumber, $userId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to register account.']);
        }

        $stmt->close();
        $db->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    }
}
?>
