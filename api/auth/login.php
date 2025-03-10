<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ Ensure secure session handling
ini_set('session.cookie_lifetime', 86400); // 1 day
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);

header("Content-Type: application/json"); // Ensure JSON response
require "../cors.php";
require "../db.php";

session_start(); // Start session

$response = ['success' => false, 'message' => 'Invalid request'];

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode($response);
    exit;
}

// Read JSON input
$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required']);
    exit;
}

try {
    // Connect to database
    $db = getDatabaseConnection('jkuatcu_data');

    // Prepare statement to fetch user data
    $stmt = $db->prepare("SELECT id, password FROM cu_members WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Debugging
        error_log("Stored Hash: " . $user['password']);
        
        // Verify hashed passwords
        if (password_verify($password, $user['password'])) {
            error_log("Password matched!");

            // Generate secure API key
            $api_key = bin2hex(random_bytes(32));

            // ✅ Prevent session fixation attack
            session_regenerate_id(true);

            // ✅ Set session variables
            $_SESSION['api_key'] = $api_key;
            $_SESSION['user_id'] = $user['id'];

            // ✅ Save session immediately
            session_write_close();

            // ✅ Debug: Check if session is being stored
            error_log("Session API Key: " . ($_SESSION['api_key'] ?? 'Not Set'));
            error_log("Session User ID: " . ($_SESSION['user_id'] ?? 'Not Set'));

            $response = ['success' => true, 'api_key' => $api_key];
        } else {
            error_log("Password mismatch!");
            $response = ['success' => false, 'message' => 'Invalid credentials'];
        }
    } else {
        error_log("User not found!");
        $response = ['success' => false, 'message' => 'Invalid credentials'];
    }
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'An internal server error occurred'];
}

// Return JSON response
echo json_encode($response);
exit;
?>
