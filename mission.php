<?php

include "session.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background for subtle contrast */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            margin: auto;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .card-img-top {
            border-radius: 5%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 20px auto;
        }
        .card-title {
            color: #495057; /* Muted text color */
        }
        .btn-primary {
            background-color: #6c757d; /* Subtle primary color */
            border: none;
        }
        .btn-primary:hover {
            background-color: #5a6268;
        }
        .modal-header, .modal-footer {
            border: none;
        }
        .alert-success {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
            display: none;
        }
    </style>
</head>
<body>
    <script>
        // Check if the user already has an account
        fetch('check_account.php', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                if (data.hasAccount) {
                    // Redirect user to dashboard
                    window.location.href = "missions/pages/dashboard.php";
                }
            })
            .catch(error => console.error('Error:', error));
    </script>

    <!-- Success Alert -->
    <div class="alert alert-success" id="successAlert" role="alert">
        Registration successful! Redirecting to dashboard...
    </div>

    <div class="card text-center" style="width: 18rem;">
        <img src="makueni.jpeg" class="card-img-top" alt="User Image">
        <div class="card-body">
            <h5 class="card-title">User Registration</h5>
            <p class="card-text">Click the button below to confirm registration.</p>
            <button id="registerBtn" class="btn btn-primary">Register</button>
        </div>
    </div>

    <!-- Registration Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to register this account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="confirmBtn" type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('registerBtn').addEventListener('click', function () {
            // Show the confirmation modal
            let modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        });

        document.getElementById('confirmBtn').addEventListener('click', function () {
            // Make an AJAX request to register the account
            fetch('register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'register' }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success alert
                        let successAlert = document.getElementById('successAlert');
                        successAlert.style.display = 'block';
                        setTimeout(() => {
                            // Redirect to dashboard after 2 seconds
                            window.location.href = "missions/pages/dashboard.php";
                        }, 2000);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>
</html>
