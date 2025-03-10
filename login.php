<?php
session_start();
include './backend/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prevent SQL Injection
    $email = $mysqli->real_escape_string($email);

    // Fetch user details from the database
    $sql = "SELECT * FROM UP WHERE email = '$email' LIMIT 1";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password (assuming password is hashed in the database)s
        if (password_verify($password, $row['password'])) {
            // Start user session
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            $_SESSION['toast_message'] = "Login successful! Redirecting..."; // Success message
            header("Location: missions/pages/dashboard.php"); // Redirect to dashboard after successful login
            exit();
        } else {
            $_SESSION['toast_message'] = "Invalid password. Please try again."; // Error message for wrong password
        }
    } else {
        $_SESSION['toast_message'] = "No user found with that email."; // Error message for email not found
    }

    // Redirect back to the login page to show the message
    header("Location: login.php");
    exit();
}

// Close the database connection
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.css" rel="stylesheet">

    <style>
        .gradient-custom-2 {
            background: linear-gradient(to right, rgba(161, 196, 253, 1), rgba(194, 233, 251, 1));
        }

        .bg-indigo {
            background-color: #800000;
            border-radius: 15px;
        }

        .h-custom {
            height: 100vh !important;
        }

        .form-outline input {
            height: calc(2.5rem + 2px);
            padding-right: 2.5rem;
        }

        .form-label {
            color: #800000;
        }

        .btn-custom {
            background-color: #f7a306;
            color: white;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 2.5rem;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Centering the card */
        .d-flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Alert styling */
        .alert {
            position: relative;
            top: 20px; /* Adjusts position of alert */
        }
    </style>
</head>

<body>
    <section class="h-100 h-custom gradient-custom-2 d-flex-center">
        <div class="container py-5 h-100 d-flex-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-indigo text-white" style="border-radius: 15px;">
                    <div class="card-body p-5 text-center">
                        <h3 class="fw-bold mb-5">Sign In</h3>

                        <!-- Status Alerts -->
                        <?php if (isset($_SESSION['toast_message'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?= $_SESSION['toast_message']; unset($_SESSION['toast_message']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="login.php" method="POST" id="signInForm">
                            <div class="mb-4 pb-2">
                                <div data-mdb-input-init class="form-outline form-white">
                                    <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                    <label class="form-label" for="email">Your Email</label>
                                </div>
                            </div>

                            <div class="mb-4 pb-2">
                                <div data-mdb-input-init class="form-outline form-white password-wrapper">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                    <label class="form-label" for="password">Password</label>
                                    <i class="far fa-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-custom btn-lg btn-block" data-mdb-ripple-color="dark">Sign In</button>
                        </form>

                        <p class="mt-3"><a href="forgot.php" class="text-white" id="forgotPassword">Forgot Password?</a></p>
                        <p>Don't have an account? <a href="registration.php" style="color: #f7a306;">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- MDB JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.0/mdb.min.js"></script>
    <!-- FontAwesome for Eye Icon -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>

</html>
