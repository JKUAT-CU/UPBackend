<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CropMe Responsive Modal</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropme@1.4.3/dist/cropme.min.css">

  <style>
    .cropme-container {
      max-width: 90%;
      max-height: 90%;
    }

    #imgModal-cropme {
      direction: ltr;
    }

    #cropped-img-wrp {
      width: 100%;
      height: 100%;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
    }

  </style>
</head>

<body>
  <main role="main" class="container-fluid">
    <div class="row">
      <div class="col text-center p-2">
        <img class="mt-4" id="saved-img">
        <div class="mt-3">
          <button id="btnGetImage" class="btn btn-primary">Get Image</button>
          <input class="d-none" type="file" id="fileUpload" accept="image/*" />
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imgModal-dialog" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h3 id="imgModal-hdr">Image Editor</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div id="imgModal-msg" class="modal-body mb-2">
            <div id="cropped-img-wrp">
              <img id="cropped-img">
            </div>
            <div id="imgModal-cropme-wrp" class="justify-content-center">
              <div id="imgModal-cropme"></div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button id="imgModal-btnSave" class="btn btn-primary d-none">Save Image</button>
            <button id="imgModal-btnCrop" type="button" class="btn btn-info">Crop</button>
            <button id="imgModal-btnCancel" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cropme@1.4.3/dist/cropme.min.js"></script>

  <script>
    const CiM = {
      myCropme: null,
      options: {
        "container": {
          "width": "100%",
          "height": "100%"
        },
        "viewport": {
          "width": 200,
          "height": 200,
          "type": "square",
          "border": {
            "width": 2,
            "enable": true,
            "color": "#FF0000"
          }
        },
        "zoom": {
          "enable": true,
          "mouseWheel": true,
          "slider": true
        },
        "rotation": {
          "slider": true,
          "enable": true,
          "position": "left"
        },
        "transformOrigin": "image"
      },

      cropImage(img, callback) {
        if (this.myCropme) {
          this.myCropme.crop({ width: this.options.myFinalSize.w }).then(res => {
            img.src = res;
            this.destroyCropme();
            if (callback) callback();
          });
        } else {
          console.error("Cropme instance is not initialized.");
        }
      },

      readFile(input, callback) {
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = e => {
            const img = new Image();
            img.onload = callback;
            img.src = e.target.result;
            this.imgHolder = img;
          };
          reader.readAsDataURL(input.files[0]);
        } else {
          console.warn("No file selected");
        }
      },

      updateOptions(width) {
        const ratio = this.options.myFinalSize.w / this.options.myFinalSize.h;
        const containerWidth = Math.floor(width * 0.9);
        const containerHeight = Math.floor(containerWidth / this.options.myWinRatio);

        this.options.container.width = containerWidth;
        this.options.container.height = containerHeight;

        let vpHeight = Math.floor(containerHeight * 0.6);
        let vpWidth = Math.floor(vpHeight * ratio);

        if (vpWidth > containerWidth * 0.6) {
          vpWidth = Math.floor(containerWidth * 0.6);
          vpHeight = Math.floor(vpWidth / ratio);
        }

        this.options.viewport.width = vpWidth;
        this.options.viewport.height = vpHeight;
      },

      showCropme(cropmeDiv) {
        this.destroyCropme();
        this.myCropme = new Cropme(cropmeDiv, this.options);
        if (this.imgHolder) {
          this.myCropme.bind({ url: this.imgHolder.src });
        }
      },

      destroyCropme() {
        if (this.myCropme) {
          this.myCropme.destroy();
          this.myCropme = null;
        }
      },

      uploadImage(dataURL, callback) {
        $.ajax({
          type: "POST",
          url: "./post.php", // backend script URL
          data: { imgBase64: dataURL }
        }).done(function (resp) {
          if (callback) callback(resp);
          location.reload();
        }).fail(function (error) {
          console.error('Upload failed:', error);
        });
      }
    };

    $(document).ready(() => {
      const croppedImg = document.getElementById("cropped-img");
      const savedImg = document.getElementById("saved-img");

      CiM.options.myFinalSize = { w: 290, h: 292 };
      CiM.options.myWinRatio = 1.5;

      $("#btnGetImage").click(() => $("#fileUpload").click());

      $("#fileUpload").change(function () {
        CiM.readFile(this, () => $("#imgModal-dialog").modal("show"));
      });

      $("#imgModal-dialog").on("shown.bs.modal", () => {
        CiM.updateOptions($("#imgModal-msg").width());
        $("#imgModal-btnSave").addClass("d-none");
        $("#imgModal-btnCrop").removeClass("d-none");
        CiM.showCropme($("#imgModal-cropme")[0]);
      });

      $("#imgModal-btnCrop").click(() => {
        CiM.cropImage(croppedImg, () => {
          $("#imgModal-btnSave").removeClass("d-none");
          $("#imgModal-btnCrop").addClass("d-none");
        });
      });

      // Save button functionality
      $("#imgModal-btnSave").click(() => {
        if (croppedImg.src) {
          // Get Base64 data from the cropped image
          const dataURL = croppedImg.src;

          // Save the cropped image locally and then upload to backend
          CiM.uploadImage(dataURL, (response) => {
            console.log("Upload successful:", response);
            $("#saved-img").attr("src", croppedImg.src); // Display saved image
            $("#imgModal-dialog").modal("hide"); // Close modal
          });
        }
      });
    });
  </script>
</body>

</html>
