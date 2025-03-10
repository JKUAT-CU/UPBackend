<?php
session_start(); // Start the session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require 'backend/db.php'; // Include the database connection

// Check if the database connection is successful
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format. Please try again.";
        header("Location: forgot.php");
        exit();
    }

    // Generate a unique token
    $token = bin2hex(random_bytes(32));
    $timestamp = date('Y-m-d H:i:s');

    // Store the token in the database
    $insertTokenQuery = "INSERT INTO password_reset (email, token, created_at) VALUES (?, ?, ?)";
    $stmtInsertToken = $mysqli->prepare($insertTokenQuery);

    if (!$stmtInsertToken) {
        error_log("Database prepare failed: " . $mysqli->error);
        $_SESSION['error'] = "Something went wrong. Please try again later.";
        header("Location: forgot.php");
        exit();
    }

    $stmtInsertToken->bind_param("sss", $email, $token, $timestamp);

    if (!$stmtInsertToken->execute()) {
        error_log("Database execution failed: " . $stmtInsertToken->error);
        $_SESSION['error'] = "Unable to process your request at this time.";
        header("Location: forgot.php");
        exit();
    }

    $stmtInsertToken->close();

    // Send the email
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.jkuatcu.org';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'reset@jkuatcu.org';
        $mail->Password   = '8&+cqTnOa!A5';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Sender and recipient
        $mail->setFrom('reset@jkuatcu.org', 'JKUATCU');
        $mail->addAddress($email);

        // Email content
        $resetPasswordLink = "https://portal.jkuatcu.org/reset.php?token=$token";

        $mail->isHTML(true); // Enable HTML email
        $mail->Subject = "Password Reset Request";
        $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; }
                    .email-container { max-width: 600px; margin: 20px auto; background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
                    h2 { color: #800000; }
                    a { color: #8B4513; text-decoration: none; font-weight: bold; }
                    a:hover { color: #A0522D; }
                    .footer { margin-top: 20px; font-size: 12px; color: #666; text-align: center; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <h2>Password Reset Request</h2>
                    <p>Hello,</p>
                    <p>We received a request to reset your account password. If you made this request, please click the link below:</p>
                    <p><a href='$resetPasswordLink'>Reset Password</a></p>
                    <p>If you did not request this, you can safely ignore this email. Your account remains secure.</p>
                    <div class='footer'>
                        <p>&copy; " . date("Y") . " JKUAT CU Portal</p>
                    </div>
                </div>
            </body>
            </html>";

        // Send email
        $mail->send();

        $_SESSION['success'] = "Password reset instructions have been sent to your email.";
        header("Location: forgot.php");
        exit();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        $_SESSION['error'] = "Failed to send the email. Please try again later.";
        header("Location: forgot.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: forgot.php");
    exit();
}
?>
