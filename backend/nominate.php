<?php
// Enable PHP error reporting for troubleshooting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "db.php";

// Get raw POST data (JSON input)
$data = json_decode(file_get_contents('php://input'), true);

// Function to check if member ID exists
function memberExists($mysqli, $member_id) {
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM cu_members WHERE id = ?");
    $stmt->bind_param('i', $member_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

// Prepare SQL query for inserting each position
$sql = "INSERT INTO nominate (member_id, position) VALUES (?, ?)";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $mysqli->error);
}

// Loop through positions and insert the correct member ID
foreach ($data as $position => $nominee) {
    // Check if the position is 'Chairperson' and use 'member_id' instead of 'id'
    if ($position === 'Chairperson') {
        if (isset($nominee['member_id'])) {
            $member_id = $nominee['member_id'];
        } else {
            echo "Error: Missing member_id for Chairperson.<br>";
            continue;
        }
    } else {
        // Handle other positions with 'id'
        if (isset($nominee['id'])) {
            $member_id = $nominee['id'];
        } else {
            echo "Error: Missing id for position $position.<br>";
            continue;
        }
    }

    // Now you can check if the member ID exists and process as usual
    if (!memberExists($mysqli, $member_id)) {
        echo "Error: Member ID $member_id does not exist for position $position.<br>";
        continue;
    }

    // Bind parameters and execute the SQL
    $stmt->bind_param('is', $member_id, $position);
    if (!$stmt->execute()) {
        echo "Error inserting nomination for $position: " . $stmt->error . "<br>";
    }
}

echo "Nominations submitted successfully!";
$stmt->close();
$mysqli->close();
?>
