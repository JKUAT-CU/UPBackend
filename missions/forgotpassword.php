<?php
session_start(); // Start the session

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

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

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request body
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: pages/forgot.php");
        exit();
    }

    // Generate a unique token
    $token = bin2hex(random_bytes(32)); // Generate a random string (token)

    // Store the token in the database along with the email and timestamp
    $timestamp = date('Y-m-d H:i:s');
    $insertTokenQuery = "INSERT INTO password_reset (email, token, created_at) VALUES (?, ?, ?)";
    $stmtInsertToken = $conn->prepare($insertTokenQuery);
    $stmtInsertToken->bind_param("sss", $email, $token, $timestamp);
    $stmtInsertToken->execute();
    $stmtInsertToken->close();

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'mail.jkuatcu.org';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'reset@jkuatcu.org';                    //SMTP username
        $mail->Password   = '8&+cqTnOa!A5';                         //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to

        // Sender and recipient
        $mail->setFrom('reset@jkuatcu.org', 'JKUATCU');
        $mail->addAddress($email);

        // Email subject and body
        $mail->Subject = "Password Reset";
        $resetPasswordLink = "https://missions.jkuatcu.org/pages/reset.php?token=$token";
        $mail->Body = "Click the following link to reset your password: $resetPasswordLink";

        // Send email
        $mail->send();

        $_SESSION['success'] = "Instructions to reset your password have been sent to your email";
        header("Location: pages/forgot.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Failed to send email. Error: {$mail->ErrorInfo}";
        header("Location: pages/forgot.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request method";
    header("Location: pages/forgot.php");
    exit();
}
?>
