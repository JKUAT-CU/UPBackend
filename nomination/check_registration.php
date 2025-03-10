<?php
include 'backend/db.php'; // Ensure this file contains the correct database connection code

$email = $_POST['email'] ?? '';
$registration_number = $_POST['registration_number'] ?? '';

$response = [
    'valid' => true,
    'message' => 'Registration can proceed.'
];

// Check if email already exists
$emailCheckSql = "SELECT * FROM cu_members WHERE email = ? LIMIT 1";
$emailCheckStmt = $mysqli->prepare($emailCheckSql);
$emailCheckStmt->bind_param("s", $email);
$emailCheckStmt->execute();
$emailCheckResult = $emailCheckStmt->get_result();

if ($emailCheckResult->num_rows > 0) {
    $response['valid'] = false;
    $response['message'] = "The email address is already registered.";
}

// Check if registration number already exists
$regNumberCheckSql = "SELECT * FROM cu_members WHERE registration_number = ? LIMIT 1";
$regNumberCheckStmt = $mysqli->prepare($regNumberCheckSql);
$regNumberCheckStmt->bind_param("s", $registration_number);
$regNumberCheckStmt->execute();
$regNumberCheckResult = $regNumberCheckStmt->get_result();

if ($regNumberCheckResult->num_rows > 0) {
    $response['valid'] = false;
    // Check if there is already an error message (duplicate email), append this one
    if ($response['message'] !== 'Registration can proceed.') {
        $response['message'] .= " Also, the registration number is already registered.";
    } else {
        $response['message'] = "The registration number is already registered.";
    }
}

echo json_encode($response);
$mysqli->close();
