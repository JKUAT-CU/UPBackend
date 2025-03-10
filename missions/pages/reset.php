<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Reset Password
  </title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="missions.jkuatcu.org" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

  <style>
    .password-container {
      position: relative;
    }
    .password-input {
      padding-right: 40px;
    }
    .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
    }
  </style>
</head>

<body class="">
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('samburu.jpeg'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="card-header">
                  
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <?php
                  session_start();
                  if (isset($_SESSION['error'])) {
                      echo '<p class="text-danger">' . $_SESSION['error'] . '</p>';
                      unset($_SESSION['error']);
                  }
                  if (isset($_SESSION['success'])) {
                      echo '<p class="text-success">' . $_SESSION['success'] . '</p>';
                      unset($_SESSION['success']);
                  }
                  ?>
                  <p class="mb-0">Please add a new password</p>
                </div>

                <div class="card-body">
                  <form role="form" id="signupForm" action="../resetpassword.php" method="POST">

                   
                    <div class="input-group input-group-outline mb-3">
                      <input type="password" class="form-control password-input" name="password" id="password" placeholder="Password" required>
                      </span>
                    </div>
                    
                    <div class="input-group input-group-outline mb-3">
                        <input type="password" class="form-control password-input" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                        <span id="passwordMatchError" class="text-danger"></span> <!-- Error message placeholder -->
                    </div>

                    <!-- Hidden input field to pass the token -->
                    <input type="hidden" name="token" id="token">

                    <div class="form-check">
                      <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility(this)">
                      <label for="showPasswordCheckbox">Show Password</label>
                    </div>


                    <div class="text-center">
                      <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Reset</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
<script>
    // Retrieve the token from the URL
    var urlParams = new URLSearchParams(window.location.search);
    var token = urlParams.get('token');

    // Set the token value to the hidden input field
    document.getElementById('token').value = token;

    $(document).ready(function() {
        // When the user starts typing in the input field
        $('#name').on('input', function() {
            // Remove the placeholder
            $(this).removeAttr('placeholder');
        });
    });
</script>
  <script>
    function togglePasswordVisibility(checkbox) {
      var passwordInputs = document.querySelectorAll('input[type="password"]');
      passwordInputs.forEach(function(input) {
        input.type = checkbox.checked ? "text" : "password";
      });
    }

  </script>
  <script>
    $(document).ready(function() {
        // When the form is submitted
        $('#signupForm').submit(function(event) {
            // Get the values of password and confirm password fields
            var password = $('#password').val();
            var confirmPassword = $('#confirm_password').val();
            
            // If passwords don't match
            if (password !== confirmPassword) {
                // Show error message
                $('#passwordMatchError').text('Passwords do not match');
                // Prevent form submission
                event.preventDefault();
            }
        });
    });
</script>

</body>

</html>
