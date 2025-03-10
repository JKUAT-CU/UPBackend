<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #8B4513; /* Olden Brown */
            color: #800000; /* Maroon */
        }
        .card {
            background-color: #800000; /* Maroon */
            color: #FFFFFF; /* White text */
            border-radius: 15px;
        }
        .btn-custom {
            background-color: #8B4513; /* Olden Brown */
            color: #FFFFFF; /* White text */
            border: none;
        }
        .btn-custom:hover {
            background-color: #A0522D; /* Slightly lighter shade of Olden Brown */
            color: #FFFFFF;
        }
        .form-label {
            color: #FFFFFF;
        }
        .form-control {
            background-color: #F5F5DC; /* Beige */
            color: #800000; /* Maroon */
        }
        .password-toggle {
            cursor: pointer;
            color: #800000;
        }
        .password-toggle:hover {
            color: #A0522D;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-body p-5 text-center">
                        <h3 class="fw-bold mb-4">Reset Password</h3>
                        <!-- Status Alerts -->
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                            </div>
                        <?php elseif (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>
                        <form action="resetpassword.php" method="POST" id="resetPasswordForm">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>" />
                            <div class="mb-4 position-relative">
                                <input type="password" id="new_password" name="new_password" class="form-control form-control-lg" placeholder="New Password" required>
                                <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePasswordVisibility('new_password')">
                                    <i class="bi bi-eye" id="new_password_icon"></i>
                                </span>
                            </div>
                            <div class="mb-4 position-relative">
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-lg" placeholder="Confirm Password" required>
                                <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePasswordVisibility('confirm_password')">
                                    <i class="bi bi-eye" id="confirm_password_icon"></i>
                                </span>
                            </div>
                            <button type="submit" class="btn btn-custom btn-lg btn-block">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(`${inputId}_icon`);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }
    </script>
</body>
</html>
