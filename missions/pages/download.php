<?php
// Database credentials
$servername = "localhost";
$username = "jkuatcu_devs";
$password = "#God@isAble!#";
$database = "jkuatcu_data";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is set in session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // Query to fetch image URL from the user table
    $sql = "SELECT images FROM UP WHERE id = $user_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of the first row
        $row = $result->fetch_assoc();
        $image_url = $row["images"]; // Assuming the column name in your table is "image"
       
    } else {
        $image_url = "0 results";
    }
} else {
    echo "User ID not set in session";
    header("Location: login.php"); // Redirect to signin.php if user ID is not set
    exit();
}

// Close connection
$conn->close();
?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        .image-container {
            text-align: center;
            margin-top: 20px;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="image-container">
                <!-- Image Container with Styling -->
                <div style="height: 70%; width: 70%; border: 0.8vh solid red; border-radius: 5%; overflow: hidden;">
                    <!-- Image with dynamic source and timestamp for cache busting -->
                    <img src="<?php echo $image_url . '?timestamp=' . time(); ?>" alt="Image Preview" style="height: 100%; width: 100%; object-fit: cover;">
                </div>

                <!-- Download Button -->
                <a class="btn btn-primary mt-3 downloadButton" href="<?php echo $image_url; ?>" download="makueniproforma.jpg">
                    Download Proforma
                </a>
                        <!-- Change Image Button -->
        <a id="changeImage" class="btn btn-primary mt-3" href="scripts.php">
            Change Image
        </a>
            </div>
        </div>


    </div>
</div>




<script>
    // Function to trigger download when the button is clicked
    document.querySelectorAll(".downloadButton").forEach(function(button) {
        button.addEventListener("click", function (event) {
            var imageUrl = event.target.getAttribute("href");
            var downloadLink = document.createElement("a");
            downloadLink.href = imageUrl;
            downloadLink.download = event.target.getAttribute("download");
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            event.preventDefault();
        });
    });
</script>



<!-- Bootstrap JS and jQuery (needed for download functionality) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <script>
//     // Fetch image URL from PHP script
//     var imageUrl = "<?php echo $image_url; ?>";

//     // Function to trigger download when the button is clicked
//     document.getElementById("downloadButton").addEventListener("click", function () {
//         var downloadLink = document.createElement("a");
//         downloadLink.href = imageUrl;
//         downloadLink.download = "samburumission.jpg";
//         document.body.appendChild(downloadLink);
//         downloadLink.click();
//         document.body.removeChild(downloadLink);
//     });
// </script>

