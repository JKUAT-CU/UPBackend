<?php
require 'db.php'; // Include your database connection

// Mapping of account numbers to department names
$accountMapping = [
    'ET1' => 'CET', 'ET2' => 'NAIRET', 'ET3' => 'NET', 'ET4' => 'NORET', 'ET5' => 'NUSETA',
    'ET6' => 'MUBET', 'ET7' => 'MOUT', 'ET8' => 'SORET', 'ET9' => 'TKET', 'ET10' => 'NETWORK',
    'ET11' => 'UET', 'ET12' => 'WESO',
    'MS1' => 'CREAM', 'MS2' => 'Décor', 'MS3' => 'Edit', 'MS4' => 'Hospitality', 'MS5' => 'HCM',
    'MS6' => 'HSM', 'MS7' => 'Music Ministry', 'MS8' => 'Sound', 'MS9' => 'Sunday School',
    'MS10' => 'Ushering',
    'AS1' => 'Associates', 'CH1' => 'Challenges', 'PUBLICITY SALES' => 'Sales',
    'PUBLICITY CW' => 'Car Wash', 'CM1' => 'Committee Members', 'EC1' => 'Executive Committee',
    'WW1' => 'Well Wishers', 'PUBLICITY' => 'Main Account'
];

// Create a case-insensitive mapping by converting keys to uppercase
$caseInsensitiveMapping = [];
foreach ($accountMapping as $key => $value) {
    $caseInsensitiveMapping[strtoupper($key)] = $value;
}

// Extract account numbers for SQL query
$accountNumbers = array_keys($caseInsensitiveMapping);
$placeholders = implode(',', array_fill(0, count($accountNumbers), '?'));

// Prepare the SQL query to fetch data from the accounts table
$query = "SELECT TRIM(`BillRefNumber`) AS `BillRefNumber`, `TransAmount`, `TransTime`, `BusinessShortCode`, `TransID`
          FROM `finance`
          WHERE UPPER(TRIM(`BillRefNumber`)) IN ($placeholders)";
$stmt = $db->prepare($query);

$data = []; // Initialize an array to hold the JSON data

if ($stmt) {
    // Bind the parameters dynamically (convert account numbers to uppercase)
    $stmt->bind_param(str_repeat('s', count($accountNumbers)), ...array_map('strtoupper', $accountNumbers));
    $stmt->execute();

    // Bind the result columns
    $stmt->bind_result($billRefNumber, $transAmount, $transTime, $businessShortCode, $transID);

    // Fetch the results and process each row
    while ($stmt->fetch()) {
        // Trim the `BillRefNumber` and map the department name
        $trimmedBillRefNumber = strtoupper(trim($billRefNumber));
        $departmentName = $caseInsensitiveMapping[$trimmedBillRefNumber] ?? 'Unknown';

        // Add to the JSON data
        $data[] = [
            'DepartmentName' => $departmentName,
            'BillRefNumber' => $billRefNumber,
            'TransAmount' => $transAmount,
            'TransTime' => $transTime,
        ];
    }

    // Close the statement
    $stmt->close();
}

// Output the JSON data
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);

$db->close();
?>
