<?php
// Enable error reporting for debugging (Disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database and authentication
require "../cors.php";
include "../db.php";
include "../auth/session.php";
include "../auth/auth.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit();
}
$user_id = intval($_SESSION['user_id']);

// Handle POST request (Updating amount and sending to API)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['newAmount']) || !is_numeric($input['newAmount'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
        exit();
    }

    $newAmount = floatval($input['newAmount']);
    if ($newAmount <= 1700) {
        echo json_encode(['status' => 'error', 'message' => 'Amount must be greater than 1700.']);
        exit();
    }

    try {
        $updateQuery = $mysqli->prepare("UPDATE makueni SET amount = ? WHERE member_id = ?");
        $updateQuery->bind_param("di", $newAmount, $user_id);

        if ($updateQuery->execute()) {
            // Send update to external API
            $apiUrl = "https://example.com/api/updateAmount"; // Replace with actual API URL
            $apiData = json_encode(['user_id' => $user_id, 'new_amount' => $newAmount, 'status' => 'updated']);

            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $apiData);
            $response = curl_exec($ch);
            curl_close($ch);

            echo json_encode(['status' => 'success', 'message' => 'Amount updated successfully.', 'api_response' => json_decode($response, true)]);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update amount.']);
            exit();
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database error occurred.']);
    }
    exit();
}

// Handle GET request (Fetching transactions and sending to API)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch user account details
    $userQuery = $mysqli->prepare("SELECT account_number, amount FROM makueni WHERE member_id = ?");
    $userQuery->bind_param("i", $user_id);
    $userQuery->execute();
    $userQuery->bind_result($accountNumber, $collectionAmount);

    if (!$userQuery->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'No account details found.']);
        exit();
    }
    $userQuery->close();

    // Validate input
    if (!isset($_GET['accountNumber']) || empty(trim($_GET['accountNumber']))) {
        echo json_encode(['status' => 'error', 'message' => 'Missing or invalid account number.']);
        exit();
    }
    $accountNumber = strtoupper(trim($_GET['accountNumber']));

    // Fetch transactions
    $query = "SELECT TRIM(`BillRefNumber`), `TransAmount`, `TransTime`, `BusinessShortCode`, `TransID`
              FROM `finance` WHERE UPPER(TRIM(`BillRefNumber`)) = ?";
    $data = [];

    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("s", $accountNumber);
        if ($stmt->execute()) {
            $stmt->bind_result($billRefNumber, $transAmount, $transTime, $businessShortCode, $transID);
            while ($stmt->fetch()) {
                $data[] = [
                    'BillRefNumber' => $billRefNumber,
                    'TransAmount' => $transAmount,
                    'TransTime' => $transTime,
                    'BusinessShortCode' => $businessShortCode,
                    'TransID' => $transID,
                ];
            }
        }
        $stmt->close();
    }

    // Send transaction data to external API
    $apiUrl = "https://example.com/api/transactions"; // Replace with actual API URL
    $apiData = json_encode($data);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $apiData);
    $response = curl_exec($ch);
    curl_close($ch);

    // Return both local data and API response
    echo json_encode([
        'local_data' => $data,
        'api_response' => json_decode($response, true)
    ], JSON_PRETTY_PRINT);
    exit();
}

// If request method is invalid
echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
exit();
?>
