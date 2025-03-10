<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    JKUATCU MISSIONS
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
                    <h4 class="font-weight-bolder">REGISTER</h4>
                  <p class="mb-0">Please fill in your details</p>
                  <p class="mb-2 text-sm mx-auto">
                    Already have an account?
                    <a href="signin.php" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                                  <?php
                session_start();
                // Check if error message is set in session
                if(isset($_SESSION['error'])){
                    // Display error message
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                    // Remove error message from session
                    unset($_SESSION['error']);
                }
                ?>
                </div>

                <div class="card-body">
                  <form role="form" id="signupForm" action="../register.php" method="POST">

                    <div class="input-group input-group-outline mb-3">
                    
                      <input type="text" class="form-control" name="name" placeholder="Name" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                     
                      <input type="tel" id="phoneNumber" class="form-control" name="phoneNumber" placeholder="Phone Number" required>
                      <div class="invalid-feedback">Phone number must have 10 digits.</div>
                    </div>

                   <div class="input-group input-group-outline mb-3">
                  <select class="form-control" id="yearOfStudy" name="yearOfStudy" required>
                    <option value="" disabled selected hidden>Year of Study</option>
                    <option>One</option>
                    <option>Two</option>
                    <option>Three</option>
                    <option>Four</option>
                    <option>Five</option>
                    <option>Six</option>
                    <option>Associate</option>
                  </select>
                </div>
                
                <div class="input-group input-group-outline mb-3">
                  <select class="form-control" id="evangelisticTeams" name="evangelisticTeams" required>
                    <option value="" disabled selected hidden>Evangelistic Team</option>
                    <option>NET</option>
                    <option>NAIRET</option>
                    <option>TIKET</option>
                    <option>MOUT</option>
                    <option>MUBET</option>
                    <option>NETWORK</option>
                    <option>WESO</option>
                    <option>NUSETA</option>
                    <option>CET</option>
                    <option>NORET</option>
                    <option>SORET</option>
                    <option>UET</option>
                    <option>NONE</option>
                  </select>
                </div>
                
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                  $(document).ready(function() {
                    // Disable blank option and show placeholder instead
                    $('select[required]').on('change', function() {
                      if ($(this).val() === '') {
                        $(this).addClass('error');
                      } else {
                        $(this).removeClass('error');
                      }
                    });
                  });
                </script>


                    <div class="input-group input-group-outline mb-3">
                     
                      <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group input-group-outline mb-3">
                      <input type="password" class="form-control password-input" name="password" id="password" placeholder="Password" required>
                      </span>
                    </div>
                    
                    <div class="input-group input-group-outline mb-3">
                        <input type="password" class="form-control password-input" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
                        <span id="passwordMatchError" class="text-danger"></span> <!-- Error message placeholder -->
                    </div>

                    
                    <div class="form-check">
                      <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility(this)">
                      <label for="showPasswordCheckbox">Show Password</label>
                    </div>


                    <div class="text-center">
                      <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign Up</button>
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


    function validateForm() {
      const phoneNumberInput = document.getElementById('phoneNumber');
      const phoneNumber = phoneNumberInput.value.replace(/\D/g, ''); // Remove non-digit characters
      if (phoneNumber.length !== 10) {
        phoneNumberInput.classList.add('is-invalid');
        return false; // Prevent form submission
      } else {
        phoneNumberInput.classList.remove('is-invalid');
        return true; // Allow form submission
      }
    }
  </script>
  <script>
    $(document).ready(function() {
        // When the form is submitted
        $('#signupForm').submit(function(event) {
            // Get the values of password and confirm password fields
            var password = $('#password').val();
            var confirmPassword = $('#confirmpassword').val();
            
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
