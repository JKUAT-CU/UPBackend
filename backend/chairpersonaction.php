<?php
// Start session if needed
session_start();

// Function to log messages to the page instead of a log file
function logMessage($message) {
    $currentDateTime = date("Y-m-d H:i:s");
    echo "<p>[$currentDateTime] $message</p>";
}

// Log request start
logMessage("Form submission started.");

// Database connection
include 'db.php'; // Adjust based on file location

if (!$mysqli) {
    logMessage("Database connection failed.");
    die("Database connection failed.");
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logMessage("POST request received.");
    
    // Check if selected_members is set
    if (isset($_POST['selected_members']) && !empty($_POST['selected_members'])) {
        logMessage("Selected members data received: " . $_POST['selected_members']);
        
        // Decode the JSON string into an array
        $members = json_decode($_POST['selected_members'], true);
        
        // Check if decoding was successful
        if ($members === null) {
            logMessage("Error decoding JSON: " . json_last_error_msg());
            die("Error decoding JSON: " . json_last_error_msg());
        }

        // Ensure we have an array of member IDs
        if (is_array($members)) {
            logMessage("Decoded members array: " . print_r($members, true));
            
            // Prepare the SQL statement
            $stmt = $mysqli->prepare("INSERT INTO chairpersons (member_id) VALUES (?)");
            
            if (!$stmt) {
                $errorMessage = "Prepare failed: " . $mysqli->error;
                logMessage($errorMessage);
                die($errorMessage);
            }

            // Insert each selected member into the chairpersons table
            foreach ($members as $member_id) {
                logMessage("Inserting member ID: $member_id");
                $stmt->bind_param("i", $member_id);
                if (!$stmt->execute()) {
                    $error = "Error inserting member with ID $member_id: " . $stmt->error;
                    logMessage($error);
                    echo $error;
                } else {
                    logMessage("Successfully inserted member ID: $member_id");
                }
            }
            
            // Close statement
            $stmt->close();
            logMessage("SQL statement closed.");
            
            // Redirect or display success message
            logMessage("Redirecting to chairpersonaction.php with success.");
            header("Location: chairpersonaction.php?success=1");
            exit();
        } else {
            logMessage("Invalid members data. Data: " . print_r($members, true));
            echo "Invalid members data.";
        }
    } else {
        logMessage("No members selected.");
        echo "No members selected.";
    }
} else {
    logMessage("Invalid request method.");
    echo "Invalid request method.";
}

// Close database connection
if (isset($mysqli) && $mysqli) {
    logMessage("Closing database connection.");
    $mysqli->close();
}
?>
