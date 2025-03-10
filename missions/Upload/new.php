<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crop and Save Image</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">
<style>
  .img-container {
    width: 100%;
    text-align: center;
    margin-bottom: 20px;
  }
  img {
    max-width: 100%;
  }
</style>
</head>
<body>

<div class="container">
  <h1 class="text-center mt-5">Crop and Save Image</h1>
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <input type="file" id="inputImage" class="form-control mb-3" accept="image/*">
      <div class="img-container">
        <img id="image" src="https://via.placeholder.com/300" alt="Picture">
      </div>
      <button class="btn btn-primary btn-block" id="cropButton">Crop Image</button>
    </div>
  </div>
</div>

<!-- Latest compiled JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>

<script>
$(function() {
  var cropper;

  $('#inputImage').change(function(event) {
    var files = event.target.files;
    var file;

    if (files && files.length > 0) {
      file = files[0];

      if (file.type.match(/^image\//)) {
        var reader = new FileReader();
        reader.onload = function() {
          $('#image').attr('src', reader.result);

          if (cropper) {
            cropper.destroy();
          }

          cropper = new Cropper(image, {
            aspectRatio: 1 / 1,
            viewMode: 1,
          });
        };
        reader.readAsDataURL(file);
      } else {
        alert('Please choose an image file.');
      }
    }
  });

  $('#cropButton').click(function() {
    var canvas = cropper.getCroppedCanvas({
      width: 240,
      height: 292,
    });

    canvas.toBlob(function(blob) {
      var formData = new FormData();
      formData.append('croppedImage', blob);

      $.ajax('post.php', {
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          alert(response);
        },
        error: function() {
          alert('Error occurred while cropping and saving image.');
        },
      });
    }, 'image/png');
  });
});
</script>

</body>
</html>
