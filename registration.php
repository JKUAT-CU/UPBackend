<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include database connection
include 'backend/db.php'; // Ensure this file contains the correct database connection code

$db = new mysqli('localhost', 'jkuatcu_devs', '#God@isAble!#', 'jkuatcu_data');

if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to generate a unique account number
function generateAccountNumber($db) {
    $prefix = "UP";
    do {
        $randomNumber = str_pad(mt_rand(1, 999), 3, "0", STR_PAD_LEFT);
        $accountNumber = $prefix . $randomNumber;

        // Check if account number exists
        $stmt = $db->prepare("SELECT id FROM UP WHERE account_number = ?");
        $stmt->bind_param("s", $accountNumber);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($exists);

    return $accountNumber;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $first_name = trim($_POST['first_name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirmation = $_POST['confirm_password'] ?? '';

    // Password validation
    if ($password !== $password_confirmation) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    // Email existence check
    $emailCheckStmt = $db->prepare("SELECT id FROM UP WHERE email = ? LIMIT 1");
    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailCheckStmt->store_result();

    if ($emailCheckStmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email is already registered.']);
        exit;
    }
    $emailCheckStmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $accountNumber = generateAccountNumber($db);

    // Insert user data
    $stmt = $db->prepare("INSERT INTO UP (first_name, surname, email, password, account_number) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $surname, $email, $hashed_password, $accountNumber);

    if ($stmt->execute()) {
        // Redirect to login.php after successful registration
        header("Location: login.php");
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed.']);
    }

    $stmt->close();
    $db->close();
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">

    <style>
        /* General styling */
        .container {
            background-color: #f7a306;
            height: 100%;
        }
        .gradient-custom-2 {
            background-color: #f7a306;
        }
        .bg-indigo {
            background-color: #800000;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .bg-secondary {
            background-color: #089000;
        }
        .h-custom {
            height: 100vh !important;
        }
        .form-label {
            color: #800000;
        }
        .btn-custom {
            background-color: #f7a306;
            color: white;
        }
        .dark-bg .form-control {
            background-color: #f7f7f7;
            color: #000;
            border: 1px solid #ddd;
        }
        .light-bg .form-control {
            background-color: #fff;
            color: #000;
            border: 1px solid #ccc;
        }
        /* Media Queries */
        @media (max-width: 991px) {
            .bg-indigo {
                border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
            }
        }
    </style>
</head>
<body>

<section class="h-100 h-custom gradient-custom-2">

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['alert_type']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION['message']); endif; ?>

    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Light Background Section -->
                            <div class="col-lg-6 light-bg">
                                <div class="p-5">
                                    <p>Have an account? <a href="login.php" style="color: #f7a306;">Login here</a></p>
                                    <h3 class="fw-normal mb-5" style="color: #800000;">General Information</h3>
                                    <form method="POST" action="registration.php" onsubmit="return validateEmail();">
                                        <!-- First Name -->
                                        <div class="mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="text" id="first_name" name="first_name" class="form-control form-control-lg" required />
                                                <label class="form-label" for="first_name">First Name</label>
                                            </div>
                                        </div>
                                        <!-- Surname -->
                                        <div class="mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="text" id="surname" name="surname" class="form-control form-control-lg" required />
                                                <label class="form-label" for="surname">Surname</label>
                                            </div>
                                        </div>
                                   
                        <!-- Display logs -->
                        <!-- <h4>Logs:</h4>
                        <ul>
                            <?php foreach ($log as $log_message): ?>
                                <li><?= htmlspecialchars($log_message) ?></li>
                            <?php endforeach; ?>
                        </ul> -->
                                </div>
                            </div>
                            <!-- Dark Background Section -->
                            <div class="col-lg-6 bg-indigo dark-bg">
                                <div class="p-5">
                                    <h3 class="fw-normal mb-5" style="color: white;">Contact Information</h3>
                                                                            <!-- Email -->
                                        <div class="mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                                <label class="form-label" for="email">Email Address</label>
                                            </div>
                                        </div>
                                        <div class="mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                            <button type="button" class="btn btn-outline-light" onclick="togglePasswordVisibility()">Show Password</button>
                                        </div>
                                        <!-- Confirm Password -->
                                        <div class="mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" required />
                                                <label class="form-label" for="confirm_password">Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="pt-2">
                                            <button type="submit" class="btn btn-custom btn-lg">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- End Row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<!-- MDB UI Kit JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>

<!-- Custom JS -->
<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById("password");
    var confirmPasswordField = document.getElementById("confirm_password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        confirmPasswordField.type = "text";
    } else {
        passwordField.type = "password";
        confirmPasswordField.type = "password";
    }
}

function validateEmail() {
    var emailField = document.getElementById('email');
    var email = emailField.value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert('Please enter a valid email address.');
        emailField.focus();
        return false;
    }
    return true;
}

function validatePassword(password) {
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /[0-9]/.test(password);
    const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    if (password.length < minLength) {
        alert("Password must be at least 8 characters long.");
        return false;
    }
    if (!hasUpperCase) {
        alert("Password must contain at least one uppercase letter.");
        return false;
    }
    if (!hasLowerCase) {
        alert("Password must contain at least one lowercase letter.");
        return false;
    }
    if (!hasNumbers) {
        alert("Password must contain at least one number.");
        return false;
    }
    if (!hasSpecialChars) {
        alert("Password must contain at least one special character.");
        return false;
    }

    return true;
}

function validateForm() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm_password');

    // Validate Email first
    if (!validateEmail()) {
        return false;
    }

    // Validate Password
    const password = passwordField.value;
    if (!validatePassword(password)) {
        passwordField.focus();
        return false;
    }

    // Check if passwords match
    if (password !== confirmPasswordField.value) {
        alert("Passwords do not match.");
        confirmPasswordField.focus();
        return false;
    }

    return true; // All validations passed
}
</script>
</body>
</html>
