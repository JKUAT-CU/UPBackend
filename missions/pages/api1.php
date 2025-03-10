<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database connection details
$host = 'localhost';
$user = 'jkuatcu_devs';
$password = '#God@isAble!#'; 
$database = "jkuatcu_daraja";

// Create a connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch TransTime, TransAmount, and BillRefNumber
$sql = "SELECT TransTime, TransAmount, BillRefNumber FROM finance";
$result = $conn->query($sql);

$data = [];

// Process the results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
