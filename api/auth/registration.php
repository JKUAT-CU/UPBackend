<?php
require "../cors.php";
header("Content-Type: application/json");

// Include database connection
include 'backend/db.php';

// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit;
}

// Read input data
$input = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$required_fields = ["registration_number", "first_name", "surname", "gender", "county_id", "course_id", "email", "phone", "year_of_study", "password", "confirm_password"];
foreach ($required_fields as $field) {
    if (empty($input[$field])) {
        echo json_encode(["error" => "$field is required"]);
        exit;
    }
}

// Extract form data
$registration_number = $input['registration_number'];
$first_name = $input['first_name'];
$surname = $input['surname'];
$gender = $input['gender'];
$county_id = $input['county_id'];
$course_id = $input['course_id'];
$email = $input['email'];
$mobile_number = $input['phone'];
$year_of_study = $input['year_of_study'];
$password = $input['password'];
$confirm_password = $input['confirm_password'];
$avatar = 'default.png';
$role = 'member';

// Validate email uniqueness
$emailCheckSql = "SELECT id FROM cu_members WHERE email = ? LIMIT 1";
$emailCheckStmt = $mysqli->prepare($emailCheckSql);
$emailCheckStmt->bind_param("s", $email);
$emailCheckStmt->execute();
$emailCheckStmt->bind_result($emailResult);
$emailExists = $emailCheckStmt->fetch();
$emailCheckStmt->close();

if ($emailExists) {
    echo json_encode(["error" => "The email address is already registered."]);
    exit;
}

// Validate registration number uniqueness
$regNumberCheckSql = "SELECT id FROM cu_members WHERE registration_number = ? LIMIT 1";
$regNumberCheckStmt = $mysqli->prepare($regNumberCheckSql);
$regNumberCheckStmt->bind_param("s", $registration_number);
$regNumberCheckStmt->execute();
$regNumberCheckStmt->bind_result($regNumberResult);
$regNumberExists = $regNumberCheckStmt->fetch();
$regNumberCheckStmt->close();

if ($regNumberExists) {
    echo json_encode(["error" => "The registration number is already registered."]);
    exit;
}

// Check password confirmation
if ($password !== $confirm_password) {
    echo json_encode(["error" => "Passwords do not match"]);
    exit;
}

// Check password strength
if (strlen($password) < 8) {
    echo json_encode(["error" => "Password must be at least 8 characters long"]);
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
$stmt = $mysqli->prepare("INSERT INTO cu_members (registration_number, first_name, surname, gender, county_id, course_id, email, mobile_number, year_of_study, password, avatar, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssiissssss", $registration_number, $first_name, $surname, $gender, $county_id, $course_id, $email, $mobile_number, $year_of_study, $hashed_password, $avatar, $role);

if ($stmt->execute()) {
    echo json_encode(["success" => "Registration successful"]);
} else {
    echo json_encode(["error" => "Error: " . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>
