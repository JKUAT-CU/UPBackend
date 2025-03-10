<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../backend/db.php"; // Database connection ($mysqli)
require_once "../session.php"; // Handles user session

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo 'Error: User not authenticated.';
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if request method is POST and image data is provided
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['imgBase64'])) {
    http_response_code(400);
    echo 'Error: Invalid request or missing image data.';
    exit();
}

$maxFileSize = 5 * 1024 * 1024; // 5MB limit
$imgBase64 = $_POST['imgBase64'];

// Decode base64 image
$imgData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgBase64));
if (!$imgData || strlen($imgData) > $maxFileSize) {
    http_response_code(413);
    echo 'Error: Invalid or too large image.';
    exit();
}

// Fetch user details
$userSql = "SELECT account_number FROM UP WHERE id = ?";
$stmt = $mysqli->prepare($userSql);
if (!$stmt) {
    http_response_code(500);
    echo "Database Error: " . $mysqli->error;
    exit();
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($accountNo);

if (!$stmt->fetch()) {
    http_response_code(404);
    echo "Error: User not found.";
    $stmt->close();
    exit();
}
$stmt->close();

// Default poster image path
$defaultPosterPath = '../uploads/UP.png';
if (!file_exists($defaultPosterPath)) {
    http_response_code(500);
    echo "Error: Default poster image not found.";
    exit();
}

list($posterWidth, $posterHeight) = getimagesize($defaultPosterPath);
$posterImage = imagecreatefrompng($defaultPosterPath);
if (!$posterImage) {
    http_response_code(500);
    echo "Error: Could not load poster image.";
    exit();
}

// Create uploaded image resource
$uploadedImage = imagecreatefromstring($imgData);
if (!$uploadedImage) {
    http_response_code(415);
    echo "Error: Invalid image format.";
    exit();
}

$uploadedImageWidth = imagesx($uploadedImage);
$uploadedImageHeight = imagesy($uploadedImage);

// **Step 1: Enlarge Image by 10%**
$scaleFactor = 1.;
$newWidth = intval($uploadedImageWidth * $scaleFactor);
$newHeight = intval($uploadedImageHeight * $scaleFactor);

$enlargedImage = imagecreatetruecolor($newWidth, $newHeight);
imagealphablending($enlargedImage, false);
imagesavealpha($enlargedImage, true);
$transparent = imagecolorallocatealpha($enlargedImage, 0, 0, 0, 127);
imagefill($enlargedImage, 0, 0, $transparent);

imagecopyresampled($enlargedImage, $uploadedImage, 0, 0, 0, 0, $newWidth, $newHeight, $uploadedImageWidth, $uploadedImageHeight);

// **Step 2: Apply 3% Border Radius**
$borderRadius = intval(min($newWidth, $newHeight) * 0.10);
$mask = imagecreatetruecolor($newWidth, $newHeight);
$black = imagecolorallocate($mask, 0, 0, 0);
$white = imagecolorallocate($mask, 255, 255, 255);

imagefill($mask, 0, 0, $white);
imagefilledrectangle($mask, $borderRadius, 0, $newWidth - $borderRadius, $newHeight, $black);
imagefilledrectangle($mask, 0, $borderRadius, $newWidth, $newHeight - $borderRadius, $black);
imagefilledellipse($mask, $borderRadius, $borderRadius, $borderRadius * 2, $borderRadius * 2, $black);
imagefilledellipse($mask, $newWidth - $borderRadius, $borderRadius, $borderRadius * 2, $borderRadius * 2, $black);
imagefilledellipse($mask, $borderRadius, $newHeight - $borderRadius, $borderRadius * 2, $borderRadius * 2, $black);
imagefilledellipse($mask, $newWidth - $borderRadius, $newHeight - $borderRadius, $borderRadius * 2, $borderRadius * 2, $black);

for ($x = 0; $x < $newWidth; $x++) {
    for ($y = 0; $y < $newHeight; $y++) {
        $maskPixel = imagecolorat($mask, $x, $y) & 0xFF;
        if ($maskPixel > 128) {
            imagesetpixel($enlargedImage, $x, $y, $transparent);
        }
    }
}

// **Step 3: Merge onto Poster**
$centerX = 403;
$centerY = 865;

$x = $centerX - ($newWidth / 2);
$y = $centerY - ($newHeight / 2);

imagecopy($posterImage, $enlargedImage, $x, $y, 0, 0, $newWidth, $newHeight);

// **Step 4: Add Account Number Text**
$textColor = imagecolorallocate($posterImage, 255, 255, 255);
$font = realpath('../assets/fonts/Futura-Bold.ttf');
if (!$font) {
    http_response_code(500);
    echo "Error: Font file not found.";
    exit();
}

$fontSize = 38;
imagettftext($posterImage, $fontSize, 0, 1040, 1295, $textColor, $font, $accountNo);

// **Step 5: Save Final Image**
$mergedImagePath = '../uploads/' . $user_id . '.png';
imagepng($posterImage, $mergedImagePath);

// Free memory
imagedestroy($posterImage);
imagedestroy($uploadedImage);
imagedestroy($enlargedImage);
imagedestroy($mask);

// **Step 6: Update Database**
$query1 = "UPDATE UP SET images = ? WHERE id = ?";
$stmt1 = $mysqli->prepare($query1);
if (!$stmt1) {
    http_response_code(500);
    echo "Database Error: " . $mysqli->error;
    exit();
}

$stmt1->bind_param("si", $mergedImagePath, $user_id);
if (!$stmt1->execute()) {
    http_response_code(500);
    echo "Error updating image: " . $stmt1->error;
    exit();
}

$stmt1->close();

// Return success response
echo json_encode(["success" => true, "image" => $mergedImagePath]);
?>
