<?php
// Database connection
include 'backend/db.php';
include 'sidebar.php';

// Fetch members from the members table
$query = "SELECT id, CONCAT(first_name, ' ', surname) AS full_name FROM cu_members";
$result = $mysqli->query($query);

if (!$result) {
    die("Database query failed: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chairpersons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Global styling */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .content {
            padding: 40px 20px;
        }

        /* Search bar styling */
        #search-bar {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            font-size: 16px;
        }

        /* Profile card grid */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            grid-gap: 20px;
        }

        /* Profile card styling */
        .profile-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
        }
        .profile-card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .profile-card h5 {
            font-size: 1.1em;
            color: #343a40;
            margin-bottom: 5px;
        }
        .profile-card p {
            font-size: 0.9em;
            color: #6c757d;
            margin-bottom: 15px;
        }

        /* Button styling */
        .btn-primary {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="container">
            <h2 class="mb-4">Add Chairpersons</h2>

            <!-- Search Bar -->
            <input type="text" id="search-bar" placeholder="Search for members...">

            <!-- Profile Cards Grid -->
            <div class="profile-grid" id="profile-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="profile-card" data-name="<?php echo strtolower($row['full_name']); ?>">
                        <img src="uploads/default-profile.jpg" alt="<?php echo $row['full_name']; ?>"> <!-- Placeholder image -->
                        <h5><?php echo htmlspecialchars($row['full_name']); ?></h5>
                        <input type="checkbox" class="member-checkbox" value="<?php echo $row['id']; ?>"> Select as Chairperson
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Hidden form to hold selected chairpersons -->
            <form action="backend/chairpersonaction.php" method="post" id="chairperson-form">
                <input type="hidden" name="selected_members" id="selected-members">
                <button type="submit" class="btn btn-primary mt-4">Add Chairpersons</button>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedMembers = [];

            // Update selected members array when a checkbox is clicked
            $('.member-checkbox').on('change', function() {
                const memberId = $(this).val();

                if ($(this).is(':checked')) {
                    selectedMembers.push(memberId);
                } else {
                    selectedMembers = selectedMembers.filter(id => id !== memberId);
                }

                // Update hidden input field with the selected members array
                $('#selected-members').val(JSON.stringify(selectedMembers));
            });

            // Search functionality
            $('#search-bar').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.profile-card').each(function() {
                    var name = $(this).data('name');
                    if (name.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
