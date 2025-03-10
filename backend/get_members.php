<?php
// Display PHP errors in the browser for troubleshooting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

// Fetch chairpersons from the chairpersons table with detailed member information
$chairpersons_sql = "
    SELECT 
        chairpersons.member_id,
        cu_members.id AS member_id,
        cu_members.first_name,
        cu_members.surname,
        cu_members.year_of_study,
        cu_dets.name AS det_name,
        cu_ministries.name AS ministry_name
    FROM 
        chairpersons
    JOIN cu_members ON chairpersons.member_id = cu_members.id
    LEFT JOIN cu_dets ON cu_members.det_id = cu_dets.id
    LEFT JOIN cu_ministries ON cu_members.ministry_id = cu_ministries.id
";

$chairpersons_result = $mysqli->query($chairpersons_sql);

if (!$chairpersons_result) {
    die("Chairpersons query failed: " . $mysqli->error);
}

// Prepare an array to store the full chairperson details
$chairpersons = [];

// Process the chairpersons
while ($row = $chairpersons_result->fetch_assoc()) {
    $chairpersons[] = [
        'member_id' => $row['member_id'],
        'id' => $row['member_id'],
        'first_name' => $row['first_name'],
        'surname' => $row['surname'],
        'year_of_study' => !empty($row['year_of_study']) ? $row['year_of_study'] : 'N/A',
        'det' => !empty($row['det_name']) ? $row['det_name'] : 'N/A',
        'ministry' => !empty($row['ministry_name']) ? $row['ministry_name'] : 'N/A'
    ];
}

// Fetch all other members from the members table (for other positions)
$members_sql = "
    SELECT 
        cu_members.id, 
        cu_members.first_name, 
        cu_members.surname, 
        cu_members.year_of_study,
        cu_members.gender, 
        cu_dets.name AS det_name, 
        cu_ministries.name AS ministry_name
    FROM 
        cu_members
    LEFT JOIN cu_dets ON cu_members.det_id = cu_dets.id
    LEFT JOIN cu_ministries ON cu_members.ministry_id = cu_ministries.id
";

$members_result = $mysqli->query($members_sql);

if (!$members_result) {
    die("Members query failed: " . $mysqli->error);
}

// Prepare the array to hold the member data
$members = [];

// Process the members
while ($row = $members_result->fetch_assoc()) {
    $members[] = [
        'id' => $row['id'],
        'first_name' => $row['first_name'],
        'surname' => $row['surname'],
        'gender' => $row['gender'],
        'year_of_study' => !empty($row['year_of_study']) ? $row['year_of_study'] : 'N/A',
        'det' => !empty($row['det_name']) ? $row['det_name'] : 'N/A',
        'ministry' => !empty($row['ministry_name']) ? $row['ministry_name'] : 'N/A'
    ];
}

// Return as JSON with separate sections for chairpersons and other members
header('Content-Type: application/json');
echo json_encode([
    'chairpersons' => $chairpersons,
    'members' => $members
]);

// Close the connection
$mysqli->close();
?>
