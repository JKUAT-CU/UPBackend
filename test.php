

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


</head>
<body>
<section class="h-100 h-custom gradient-custom-2">


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
                                        <!-- Registration Number -->
                                        <div class="mb-4 pb-2">
                                            <div class="form-outline">
                                                <input type="text" id="registration_number" name="registration_number" class="form-control form-control-lg" required />
                                                <label class="form-label" for="registration_number">Registration Number</label>
                                            </div>
                                        </div>
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
                                        <!-- Gender -->
                                        <div class="mb-4 pb-2">
                                            <label class="form-label" for="gender">Gender</label>
                                            <select class="form-select form-control-lg" name="gender" required>
                                                <option value="" disabled selected>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                
                                            </select>
                                        </div>
                                        <!-- County -->
                                        <div class="mb-4 pb-2">
                                            <label class="form-label" for="county_id">County</label>
                                            <select class="form-select form-control-lg" name="county_id" required>
                                                <option value="" disabled selected>Select County</option>
                                                <?php while ($row = $counties->fetch_assoc()) : ?>
                                                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <!-- Course -->
                                        <div class="mb-4 pb-2">
                                            <label class="form-label" for="course_id">Course</label>
                                            <select class="form-select form-control-lg" name="course_id" required>
                                                <option value="" disabled selected>Select Course</option>
                                                <?php while ($row = $courses->fetch_assoc()) : ?>
                                                    <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <!-- Year of Study -->
                                        <div class="mb-4 pb-2">
                                            <label class="form-label" for="year_of_study">Year of Study</label>
                                            <select class="form-select form-control-lg" name="year_of_study" required>
                                                <option value="" disabled selected>Select Year</option>
                                                <?php foreach ($years as $year): ?>
                                                    <option value="<?= $year; ?>"><?= $year; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <!-- Submit Button -->
                                        <div class="pt-2">
                                            <button type="submit" class="btn btn-custom btn-lg">Register</button>
                                        </div>
                                    
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
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                    </div>
                                    <!-- Mobile Number -->
                                    <div class="mb-4 pb-2">
                                        <div class="form-outline">
                                            <input type="text" id="mobile_number" name="mobile_number" class="form-control form-control-lg" required />
                                            <label class="form-label" for="mobile_number">Mobile Number</label>
                                        </div>
                                    </div>

                                    <!-- Ministry -->
                                    <div class="mb-4 pb-2">
                                        <label class="form-label" for="ministry_id">Ministry</label>
                                        <select class="form-select form-control-lg" name="ministry_id" required>
                                            <option value="" disabled selected>Select Ministry</option>
                                            <?php while ($row = $ministries->fetch_assoc()) : ?>
                                                <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <!-- DET -->
                                    <div class="mb-4 pb-2">
                                        <label class="form-label" for="det_id">EVANGELISTIC TEAM</label>
                                        <select class="form-select form-control-lg" name="det_id" required>
                                            <option value="" disabled selected>Select ET</option>
                                            <?php while ($row = $dets->fetch_assoc()) : ?>
                                                <option value="<?= htmlspecialchars($row['id']); ?>"><?= htmlspecialchars($row['name']); ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control" required />
                                        <label class="form-label" for="password">Password</label>
                                        <input type="checkbox" id="togglePassword" class="mt-2" onclick="togglePasswordVisibility()">
                                        <label for="togglePassword">Show Password</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required />
                                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                                    </div>

                                    <div id="password-strength" class="mb-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


</body>
</html>
