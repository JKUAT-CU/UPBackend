<?php
// Check if image file is a actual image or fake image
if(isset($_FILES["imageUpload"])){
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        exit;
    }
    
    // Check file size
    if ($_FILES["imageUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        exit;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        exit;
    }

    if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
        // Image uploaded successfully, return the path
        echo $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
