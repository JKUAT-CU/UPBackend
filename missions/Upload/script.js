$(document).ready(function(){
    var cropper;

    $('#posterForm').submit(function(event){
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                $('#imageUpload').val('');
                $('#downloadBtn').hide();
                if (cropper) {
                    cropper.destroy();
                }
                $('#imagePreview').empty();
                $('<img>', {
                    src: response,
                    id: 'croppedImage',
                    class: 'img-fluid'
                }).appendTo('#imagePreview');
                $('#downloadBtn').show();
                initCropper();
            }
        });
    });

    function initCropper(){
        cropper = new Cropper(document.getElementById('croppedImage'), {
            aspectRatio: 1, // Aspect ratio of the crop box
            viewMode: 2, // Display the crop box within the container
            movable: true,
            zoomable: true,
            crop: function(event){
                // Output the result data for cropping image.
            }
        });
    }

    $('#downloadBtn').click(function(){
        var croppedCanvas = cropper.getCroppedCanvas();
        croppedCanvas.toBlob(function(blob){
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'event_poster_with_image.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        });
    });
});
