<?php
error_reporting(E_ALL);

session_start();

// Database connection configuration
$servername = "localhost";
$username = "jkuatcu_daraja";
$password = "K@^;daY0*j(n";
$dbname = "jkuatcu_daraja";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the user is already logged in, redirect them to the dashboard if they are
if(isset($_SESSION['user_id'])){
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);
    header("Location: pages/dashboard.php");
    exit;
}

// Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Check if email and password are set and not empty
    if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){
        
        // Get email and password from the form
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Prepare SQL statement to retrieve user data from the user table
        $sql = "SELECT id, password FROM user WHERE email = ?";
        
        // Prepare and bind parameters
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $email);
        
        // Execute the query
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            // Bind the result variables
            $stmt->bind_result($userId, $hashedPassword);
            $stmt->fetch();

            // Verify hashed password
            if (password_verify($password, $hashedPassword)) {
                // User is authenticated, store user ID in session variable
                $_SESSION['user_id'] = $userId;
                
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Redirect the user to the dashboard page
                header("Location: pages/dashboard.php");
                exit();
            } else {
                // If password is incorrect, set flash message
                $_SESSION['error'] = "Invalid email or password";
                header("Location: pages/signin.php"); // Redirect back to the login page
                exit();
            }
        } else {
            // If email is not found, set flash message
            $_SESSION['error'] = "Invalid email or password";
            header("Location: pages/signin.php");// Redirect back to the login page
            exit();
        }
    }
}

// If the code reaches this point without redirection, it means no form submission occurred or no redirection was necessary
// Therefore, any flash message set should be displayed here
if(isset($_SESSION['error'])){
    // Display error message
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
    // Remove error message from session
    unset($_SESSION['error']);
}
?>
