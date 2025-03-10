<?php
session_start();
require 'backend/db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $token = $_POST['token'] ?? '';

    if (empty($password) || empty($confirmPassword)) {
        $_SESSION['error'] = "Password fields cannot be empty.";
        header("Location: reset.php?token=" . urlencode($token));
        exit();
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset.php?token=" . urlencode($token));
        exit();
    }

    $query = "SELECT email, used, TIMESTAMPDIFF(MINUTE, created_at, NOW()) AS minutes_passed FROM password_reset WHERE token = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['error'] = "Invalid or expired token.";
        header("Location: reset.php?token=" . urlencode($token));
        exit();
    }

    $stmt->bind_result($email, $used, $minutesPassed);
    $stmt->fetch();

    if ($used || $minutesPassed > 60) {
        $_SESSION['error'] = "Token has expired or already been used.";
        header("Location: reset.php?token=" . urlencode($token));
        exit();
    }

    $stmt->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $updatePasswordQuery = "UPDATE cu_members SET password = ? WHERE email = ?";
    $stmt = $mysqli->prepare($updatePasswordQuery);
    $stmt->bind_param("ss", $hashedPassword, $email);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        $markTokenUsedQuery = "UPDATE password_reset SET used = 1 WHERE token = ?";
        $stmt = $mysqli->prepare($markTokenUsedQuery);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $_SESSION['success'] = "Password reset successful. You can now log in.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Failed to reset password.";
        header("Location: reset.php?token=" . urlencode($token));
    }
    $stmt->close();
    $mysqli->close();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: reset.php");
    exit();
}
?>
