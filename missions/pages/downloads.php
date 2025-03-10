   <?php
   // Database credentials
    $servername = "localhost";
    $username = "jkuatcu_daraja";
    $password = "K@^;daY0*j(n";
    $database = "jkuatcu_daraja";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user_id is set in session
    if(isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Query to fetch image URL from the user table
        $userSql = "SELECT images FROM user WHERE mambers_id = '$user_id'";
        $result = $conn->query($userSql);

        // Check if the query was successful
        if ($result) {
            if ($result->num_rows > 0) {
                // Fetch the image path from the database
                $row = $result->fetch_assoc();
                $image_path = $row['images'];
                // Check if the image path is empty
                if (!empty($image_path)) {
                    include 'download.php';
                } else {
                    include 'script.php';
                }
            } else {
                echo "No results found for user ID: $user_id";
            }
        } else {
            // Query execution failed
            echo "Error: " . $conn->error;
        }
    } else {
        // User ID not set in session
        echo "User ID not set in session";
        // Optionally redirect the user to the signin page
        // header("Location: signin.php");
        // exit();
    }
        // Close connection

    
?>
