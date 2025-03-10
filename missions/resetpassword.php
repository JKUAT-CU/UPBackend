<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "jkuatcu_daraja";
$password = "K@^;daY0*j(n";
$database = "jkuatcu_daraja";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $token = $_POST['token'] ?? '';

    // Validate password and confirm password
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: pages/reset.php?token=$token");
        exit();
    }

    // Check if token exists in the database and is valid
    $checkTokenQuery = "SELECT email, used, TIMESTAMPDIFF(MINUTE, created_at, NOW()) AS minutes_passed FROM password_reset WHERE token = ?";
    $stmtCheckToken = $conn->prepare($checkTokenQuery);
    
    if ($stmtCheckToken) {
        $stmtCheckToken->bind_param("s", $token);
        $stmtCheckToken->execute();
        $stmtCheckToken->store_result();

        if ($stmtCheckToken->num_rows === 0) {
            $_SESSION['error'] = "Invalid token";
            header("Location: pages/reset.php?token=$token");
            exit();
        }

        $stmtCheckToken->bind_result($email, $used, $minutesPassed);
        $stmtCheckToken->fetch();
        $stmtCheckToken->close();

        // // Check if token has expired or already been used
        // if ($used || $minutesPassed > 60) { // Token is marked as used or more than 60 minutes (1 hour) have passed
        //     $_SESSION['error'] = "Token has expired or already been used";
        //     header("Location: pages/reset.php?token=$token");
        //     exit();
        // }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $updatePasswordQuery = "UPDATE user SET password = ? WHERE email = ?";
        $stmtUpdatePassword = $conn->prepare($updatePasswordQuery);
        
        if ($stmtUpdatePassword) {
            $stmtUpdatePassword->bind_param("ss", $hashedPassword, $email);
            $stmtUpdatePassword->execute();

            if ($stmtUpdatePassword->affected_rows === 1) {
                // Mark the token as used
                $markTokenUsedQuery = "UPDATE password_reset SET used = TRUE WHERE token = ?";
                $stmtMarkTokenUsed = $conn->prepare($markTokenUsedQuery);
                $stmtMarkTokenUsed->bind_param("s", $token);
                $stmtMarkTokenUsed->execute();
                $stmtMarkTokenUsed->close();

                // Password updated successfully
                $_SESSION['success'] = "Password reset successful. You can now login with your new password.";
                header("Location: pages/signin.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to update password";
                header("Location: pages/reset.php?token=$token");
                exit();
            }
        } else {
            $_SESSION['error'] = "Failed to prepare statement for updating password: " . $conn->error;
            header("Location: pages/reset.php?token=$token");
            exit();
        }
    } else {
        $_SESSION['error'] = "Failed to prepare statement for checking token: " . $conn->error;
        header("Location: pages/reset.php?token=$token");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request method";
    header("Location: pages/reset.php");
    exit();
}
?>
