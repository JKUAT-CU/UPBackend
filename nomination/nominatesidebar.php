<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.1/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Improved Sidebar</title>
</head>
<body class="bg-light">

    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg bg-blue-600 fixed-top shadow-md topnav">
        <div class="container-fluid">
            <!-- Brand and logo -->
            <a class="navbar-brand text-white d-flex align-items-center" href="#" style="margin-left: 0;">
                <img src="assets/img/logocu.jpeg" alt="Logo" class="img-fluid rounded-circle" width="40" height="40">
                <span class="ms-2">JKUATCU</span> <!-- Updated to JKUATCU -->
            </a>

            <!-- Toggle button for mobile view -->
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar content -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Profile dropdown -->
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/img/user.jpeg" alt="User" class="rounded-circle border-2 border-white me-2" width="40" height="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#">Account</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar bg-yellow-500">
           <ul class="nav flex-column">
            </li>
            <!-- Add more positions dynamically if needed -->
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <!-- Content will go here -->
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        const selectedNominees = {};
        const positionsUrl = 'positions.json';  // URL to fetch positions
        const nomineesUrl = 'backend/get_members.php';  // URL to fetch nominees

        // Load positions dynamically
        function loadPositions() {
            fetch(positionsUrl)
                .then(response => response.json())
                .then(data => {
                    const positionsDiv = document.querySelector('.sidebar .nav');
                    positionsDiv.innerHTML += data.positions.map(position => `
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showNomineeSelection('${position}')">${position}</a>
                        </li>
                    `).join('');
                });
        }

        // Load positions when the page loads
        window.onload = loadPositions;
    </script>
</body>
</html>
