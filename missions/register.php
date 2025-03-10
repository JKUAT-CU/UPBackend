<?php
session_start(); // Start the session
include 'db.php'; // Include database connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request body
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars(trim($_POST['password'] ?? ''));
    $year = htmlspecialchars(trim($_POST['yearOfStudy'] ?? ''));
    $et = htmlspecialchars(trim($_POST['evangelisticTeams'] ?? ''));
    $mobile_no = htmlspecialchars(trim($_POST['phoneNumber'] ?? ''));

    // Validate input fields
    if (empty($name) || empty($email) || empty($password) || empty($year) || empty($et) || empty($mobile_no)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: pages/signup.php");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: pages/signup.php");
        exit();
    }

    // Validate mobile number format
    if (!preg_match("/^[0-9]{10}$/", $mobile_no)) {
        $_SESSION['error'] = "Invalid mobile number format";
        header("Location: pages/signup.php");
        exit();
    }
    
       // Check if email already exists in the database
    $checkEmailQuery = "SELECT id FROM user WHERE email = ?";
    $stmtEmail = $db->prepare($checkEmailQuery);
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    
    // Bind result variables
    $stmtEmail->bind_result($id);
    
    // Fetch result
    $stmtEmail->fetch();
    
    // If a record with the email already exists
    if ($id !== null) {
        $_SESSION['error'] = "Email already exists, sign in instead";
        header("Location: pages/signup.php");
        exit();
    }
    
    $stmtEmail->close();
    
    // Check if phone number already exists in the database
    $checkPhoneQuery = "SELECT id FROM user WHERE mobile_no = ?";
    $stmtPhone = $db->prepare($checkPhoneQuery);
    $stmtPhone->bind_param("s", $mobile_no);
    $stmtPhone->execute();
    
    // Bind result variables
    $stmtPhone->bind_result($id);
    
    // Fetch result
    $stmtPhone->fetch();
    
    // If a record with the phone number already exists
    if ($id !== null) {
        $_SESSION['error'] = "Phone number already exists, sign in instead";
        header("Location: pages/signup.php");
        exit();
    }
    
    $stmtPhone->close();


    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Function to generate a unique account number
    function generateAccountNumber($db) {
        $prefix = "SM24";
        $randomNumber = str_pad(mt_rand(1, 999), 3, "0", STR_PAD_LEFT); // Generate random number between 001 and 999
        $accountNumber = $prefix . $randomNumber;

        // Check if the generated number is already in use
        $checkQuery = "SELECT account_no FROM user WHERE account_no = ?";
        $stmt = $db->prepare($checkQuery);
        $stmt->bind_param("s", $accountNumber);
        $stmt->execute();
        $stmt->store_result();

        // If the generated number is not unique, recursively call the function to generate a new one
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return generateAccountNumber($db);
        }

        $stmt->close();
        return $accountNumber;
    }

    // Generate a unique account number
    $accountNumber = generateAccountNumber($db);

    // Prepare SQL statement to insert user data into the database
    $stmt = $db->prepare("INSERT INTO user (name, email, password, year_of_study, evangelistic_team, mobile_no, account_no) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $hashed_password, $year, $et, $mobile_no, $accountNumber);

    // Execute the prepared statement
    if ($stmt->execute()) {
        $userId = $stmt->insert_id;
        
        // Store the user ID in a session variable
        $_SESSION['user_id'] = $userId;

        // Redirect the user to the dashboard page
        header("Location: pages/dashboard.php");
        exit();
    } else {
        // Registration failed
        $_SESSION['error'] = "Registration failed";
        header("Location: pages/signup.php");
        exit();
    }

    // Close statement
    $stmt->close();
} else {
    // Handle other request methods if necessary
    $_SESSION['error'] = "Invalid request method";
    header("Location: pages/signup.php");
    exit();
}
?>
