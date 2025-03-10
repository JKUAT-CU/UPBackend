<?php

session_start();

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
    // Check if the request method is POST and if an image base64 data is sent
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imgBase64'])) {
        // Define the maximum file size (5MB)
        $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

        // Get the image base64 data
        $imgBase64 = $_POST['imgBase64'];

        // Decode the base64 data
        $imgData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgBase64));

        // Check if the image data is valid
        if (!$imgData || strlen($imgData) > $maxFileSize) {
            echo 'Error: Invalid image data.';
            exit();
        }

        // Query to retrieve the account number and email from the user table using user_id
        $userSql = "SELECT email FROM user WHERE id = '$user_id'";
        $result = $conn->query($userSql);
        
        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch the account number and email as an associative array
            $row = $result->fetch_assoc();
            $userEmail = $row["email"]; // Retrieve the user's email address
            $posterImagePath = 'uploads/attending.png';
            
        
            // Continue with the rest of the image processing and database operations...
        } else {
            // Handle the case where no account number is found
            echo "Error: Unable to retrieve email.";
        }

        
        $posterImage = imagecreatefrompng($posterImagePath);

        // Create a new image from the uploaded image data
        $uploadedImage = imagecreatefromstring($imgData);

        // Get the dimensions of the uploaded image
        $uploadedImageWidth = imagesx($uploadedImage);
        $uploadedImageHeight = imagesy($uploadedImage);

        // Define the coordinates of the center of the uploaded image
        $centerX = 339; // X-coordinate
        $centerY = 597; // Y-coordinate

        // Calculate the top-left corner coordinates for positioning the image based on its center
        $x = $centerX - ($uploadedImageWidth / 2);
        $y = $centerY - ($uploadedImageHeight / 2);

        // Merge the uploaded image with the poster image
        imagecopy($posterImage, $uploadedImage, $x, $y, 0, 0, $uploadedImageWidth, $uploadedImageHeight);
        
          // Query to retrieve the account number from the user table using user_id
    $userSql = "SELECT name FROM user WHERE id = '$user_id'";
    $result = $conn->query($userSql);

    
    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the account number as an associative array
        $row = $result->fetch_assoc();
        $name = $row['name'];

      $textColor = imagecolorallocate($posterImage, 0x00, 0x68, 0x38); // Hex color #006838

        $font = realpath('Futura-Bold.ttf'); // Get the absolute path dynamically
        $fontSize = 40;
        imagettftext($posterImage, $fontSize, 0, 144, 924, $textColor, $font, $name);
    } else {
        // Handle the case where no account number is found
        echo "Error: Unable to retrieve account number.";
    }


        // Define the path to save the merged image
        $mergedImagePath = 'uploads/attending' . $_SESSION['user_id'] . '.png';
        
        // Check if a file with the same name already exists
        if (file_exists($mergedImagePath)) {
            // Delete the existing file
            unlink($mergedImagePath);
        }
        
        // Save the merged image as a new file
        imagepng($posterImage, $mergedImagePath);


        // Free up memory
        imagedestroy($posterImage);
        imagedestroy($uploadedImage);

        // Update the database with the image link
        $imageLink = '../' . $mergedImagePath;  // Use the filename as the image link
        $query = "UPDATE user SET attend = '$imageLink' WHERE id = '$user_id'";
        $result = mysqli_query($conn, $query);
        exit();



  
    } else {
        echo 'Error: Invalid request.';
    }
} else {
    echo 'Error: User ID not set in session.';
}
?>
