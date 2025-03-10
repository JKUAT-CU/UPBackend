<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Poster Generator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
        #imagePreview {
            max-width: 100%;
            max-height: 300px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Event Poster Generator
            </div>
            <div class="card-body">
                <form id="posterForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="imageUpload">Upload Your Image:</label>
                        <input type="file" class="form-control-file" id="imageUpload" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload & Crop</button>
                </form>
                <hr>
                <h3>Crop Image</h3>
                <div id="imagePreview">
                    <!-- Image preview will be displayed here -->
                </div>
                <hr>
                <button id="downloadBtn" class="btn btn-success" style="display: none;">Download Poster</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
