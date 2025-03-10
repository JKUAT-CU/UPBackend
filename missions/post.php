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
if (isset($_SESSION['user_id'])) {
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

        // Query to retrieve the email from the user table using user_id
        $userSql = "SELECT email, name, account_no FROM user WHERE id = '$user_id'";
        $result = $conn->query($userSql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch the email as an associative array
            $row = $result->fetch_assoc();
            $userEmail = $row["email"]; // Retrieve the user's email address
            $accountNo = $row['account_no'];
            $name = $row['name'];
            $poster2 = 'uploads/attending.png';
            
            // Define the list of email addresses to determine which poster image to load
            $emailList = array("chegeperpetuah38@gmail.com", "test@test.com", "nditumurima@gmail.com","nyamgeroesther@gmail.com","nkaranja484@gmail.com", "josehgichuhi2021@gmail.com","jairuskilimo2000@gmail.com","charityjebet75@gmail.com", "wendyseda86@gmail.com", "linus12601kiprop@gmail.com", "onesmusjoseph044@gmail.com", "masterpiecewale2000jw@gmail.com", "mutindar617@gmail.com", "jesseolomayiana@gmail.com");
            $emailExec = array("samuelkitanga20@gmail.com", "mutanurehema@gmail.com","allansaboke@gmail.com","muthiniboniface782@gmail.com", "test1@test.com","daisyedna687@gmail.com","hlubiolombo7@gmail.com");
            if (in_array($userEmail, $emailList)) {
                $posterImagePath = 'uploads/poster1.png';
            }
            elseif (in_array($userEmail, $emailExec)) {
                $posterImagePath = 'uploads/poster2.png';
            } else {
                $posterImagePath = 'uploads/poster.png';
            }

            // Create a new image from the poster image
            $posterImage = imagecreatefrompng($posterImagePath);

            // Create a new image from the uploaded image data
            $uploadedImage = imagecreatefromstring($imgData);

            // Get the dimensions of the uploaded image
            $uploadedImageWidth = imagesx($uploadedImage);
            $uploadedImageHeight = imagesy($uploadedImage);

            // Define the coordinates of the center of the uploaded image
            $centerX = 336; // X-coordinate
            $centerY = 597; // Y-coordinate

            // Calculate the top-left corner coordinates for positioning the image based on its center
            $x = $centerX - ($uploadedImageWidth / 2);
            $y = $centerY - ($uploadedImageHeight / 2);

            // Merge the uploaded image with the poster image for the first poster
            imagecopy($posterImage, $uploadedImage, $x, $y, 0, 0, $uploadedImageWidth, $uploadedImageHeight);

            // Define text color for the first poster
            $textColor = imagecolorallocate($posterImage, 0x00, 0x68, 0x38); // Hex color #006838

            // Define font path for the first poster
            $font = realpath('Futura-Bold.ttf'); // Get the absolute path dynamically

            // Define font size for the first poster
            $fontSize = 30;

            // Add account number to the first poster
            imagettftext($posterImage, $fontSize, 0, 942, 1086, $textColor, $font, $accountNo);

            // Define the path to save the merged image for the first poster
            $mergedImagePath = 'uploads/' . $_SESSION['user_id'] . '.png';

            // Save the merged image as a new file for the first poster
            imagepng($posterImage, $mergedImagePath);

            // Free up memory for the first poster
            imagedestroy($posterImage);

            // Update the database with the image link for the first poster
            $imageLink1 = '../' . $mergedImagePath;  // Use the filename as the image link
            $query1 = "UPDATE user SET image = '$imageLink1' WHERE id = '$user_id'";
            $result1 = mysqli_query($conn, $query1);
            if (!$result1) {
                echo "Error updating image link in the database for the first poster.";
                exit();
            }
            
            // Create a new image from the poster image for the second poster
            $posterImage = imagecreatefrompng($poster2);

            // Get the dimensions of the uploaded image
            $uploadedImageWidth = imagesx($uploadedImage);
            $uploadedImageHeight = imagesy($uploadedImage);

            // Define the coordinates of the center of the uploaded image for the second poster
            $centerX = 339; // X-coordinate
            $centerY = 597; // Y-coordinate

            // Calculate the top-left corner coordinates for positioning the image based on its center for the second poster
            $x = $centerX - ($uploadedImageWidth / 2);
            $y = $centerY - ($uploadedImageHeight / 2);

            // Merge the uploaded image with the poster image for the second poster
            imagecopy($posterImage, $uploadedImage, $x, $y, 0, 0, $uploadedImageWidth, $uploadedImageHeight);

            // // Define text color for the second poster
            // $textColor = imagecolorallocate($posterImage, 0x00, 0x00, 0x00); // Hex color #006838

            // // Define font size for the second poster
            // $fontSize = 40;

            // Add name to the second poster
            // imagettftext($posterImage, $fontSize, 0, 148, 924, $textColor, $font);

            // Define the path to save the merged image for the second poster
            $mergedImagePath2 = 'uploads/attending_' . $_SESSION['user_id'] . '.png';

            // Save the merged image as a new file for the second poster
            imagepng($posterImage, $mergedImagePath2);

            // Free up memory for the second poster
            imagedestroy($posterImage);
            imagedestroy($uploadedImage);

            // Update the database with the image link for the second poster
            $imageLink2 = '../' . $mergedImagePath2;  // Use the filename as the image link
            $query2 = "UPDATE user SET attend = '$imageLink2' WHERE id = '$user_id'";
            $result2 = mysqli_query($conn, $query2);
            if (!$result2) {
                echo "Error updating image link in the database for the second poster.";
                exit();
            }
        } else {
            // Handle the case where no account information is found
            echo "Error: Unable to retrieve account information.";
        }
    } else {
        // Handle invalid request method or missing image data
        echo "Error: Invalid request or missing image data.";
    }
} else {
    // Handle the case where user_id is not set in session
    echo 'Error: User ID not set in session.';
}

?>
