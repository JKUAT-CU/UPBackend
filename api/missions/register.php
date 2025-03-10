<?php
require "session.php";
header("Content-Type: application/json");

// Database connection
require "db.php";

// Read JSON request
$data = json_decode(file_get_contents("php://input"), true);

// Validate request
if (!isset($data['username']) || !isset($data['email'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$username = $mysqli->real_escape_string($data['username']);
$email = $mysqli->real_escape_string($data['email']);

// Check if the user already exists
$query = $mysqli->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$query->bind_param("ss", $username, $email);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "User already registered"]);
} else {
    // Register the new user
    $stmt = $mysqli->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registration successful"]);
    } else {
        echo json_encode(["success" => false, "message" => "Registration failed"]);
    }
}

// Close connections
$query->close();
$mysqli->close();
?>
