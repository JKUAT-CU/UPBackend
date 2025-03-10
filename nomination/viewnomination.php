<?php
// Display PHP errors in the browser for troubleshooting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "backend/db.php";

// Prepare SQL query to get the nominations count for each position
$sql = "
    SELECT 
        n.position, 
        m.first_name, 
        m.surname, 
        COUNT(n.member_id) AS nomination_count 
    FROM 
        nominate n
    JOIN 
        cu_members m ON n.member_id = m.id
    GROUP BY 
        n.position, n.member_id
    ORDER BY 
        n.position ASC, nomination_count DESC
";

$result = $mysqli->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomination Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
        }
        h1, h2 {
            text-align: center;
            margin-top: 30px;
        }
        .table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #f1f1f1;
        }
        .table th {
            text-transform: uppercase;
            font-weight: bold;
        }
        .container {
            margin-top: 20px;
            padding: 20px;
        }
        .position-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h1 class="mb-5">Nomination Results</h1>

    <?php
    if ($result->num_rows > 0) {
        $nominations = [];

        // Fetch and structure the result
        while ($row = $result->fetch_assoc()) {
            $position = $row['position'];

            // Create an entry for each position if it doesn't exist
            if (!isset($nominations[$position])) {
                $nominations[$position] = [];
            }

            // Add the nominee's details to the position
            $nominations[$position][] = [
                'first_name' => $row['first_name'],
                'surname' => $row['surname'],
                'nomination_count' => $row['nomination_count']
            ];
        }

        foreach ($nominations as $position => $nominees) {
            echo "<div class='position-title'>$position</div>";
            echo '<table class="table table-striped table-bordered text-center mb-5">';
            echo '<thead><tr><th>Nominee</th><th>Number of Nominations</th></tr></thead>';
            echo '<tbody>';

            foreach ($nominees as $nominee) {
                echo "<tr>
                    <td>{$nominee['first_name']} {$nominee['surname']}</td>
                    <td>{$nominee['nomination_count']}</td>
                </tr>";
            }

            echo '</tbody></table>';
        }
    } else {
        echo "<h2 class='text-center text-muted'>No nominations found.</h2>";
    }

    $mysqli->close();
    ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
