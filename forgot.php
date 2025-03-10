<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Forgot Password</h3>

                        <!-- Status Alerts -->
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success text-center" role="alert">
                                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="forgotten.php" method="POST" id="forgotPasswordForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
