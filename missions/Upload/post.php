<?php
ini_set('upload_max_filesize', '5M');
ini_set('post_max_size', '5M');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['croppedImage'])) {
    $imageData = $_FILES['croppedImage'];
    
    if ($imageData['error'] === UPLOAD_ERR_OK) {
        $tempPath = $imageData['tmp_name'];
        
        $posterPath = 'uploads/poster.png';
        
        // Check if the poster file exists and is a valid PNG image
        if (file_exists($posterPath) && exif_imagetype($posterPath) === IMAGETYPE_PNG) {
            // Attempt to create image resources
            $croppedImage = imagecreatefrompng($tempPath);
            $poster = imagecreatefrompng($posterPath);
            
            // Check if image resources were created successfully
            if ($croppedImage && $poster) {
                // Get dimensions of cropped image
                $croppedWidth = imagesx($croppedImage);
                $croppedHeight = imagesy($croppedImage);
                
                // Calculate position to paste cropped image onto poster
                $x = ($croppedWidth > $croppedHeight) ? 0 : ($croppedHeight - $croppedWidth) / 2;
                $y = ($croppedHeight > $croppedWidth) ? 0 : ($croppedWidth - $croppedHeight) / 2;
                
                // Merge cropped image onto poster
                if (imagecopy($poster, $croppedImage, 50, 50, $x, $y, $croppedWidth, $croppedHeight)) {
                    // Save merged image
                    if (imagepng($poster, $posterPath)) {
                        echo 'Image cropped and saved successfully.';
                    } else {
                        echo 'Failed to save merged image.';
                    }
                } else {
                    echo 'Failed to merge images.';
                }
                
                // Free memory
                imagedestroy($croppedImage);
                imagedestroy($poster);
            } else {
                echo 'Failed to create image resources.';
            }
        } else {
            echo 'Poster file does not exist or is not a valid PNG image.';
        }
    } else {
        echo 'Error occurred while uploading image.';
    }
} else {
    echo 'Invalid request.';
}
?>
