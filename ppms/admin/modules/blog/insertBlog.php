<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blogEntry = $_POST['blogEntry'];
    $createdBy = $_POST['createdBy'];
    $updatedDate = $_POST['updatedDate'];

    // Handle image upload
    $target_dir = "../../../uploads/";
    $target_path = "uploads/";
    $target_file = $target_dir . basename($_FILES["blogImg"]["name"]);
    $target_fileDB = $target_path . basename($_FILES["blogImg"]["name"]);
    $upload_ok = 1;
   
    // Check if image file is an actual image
    $check = getimagesize($_FILES["blogImg"]["tmp_name"]);
    if ($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Move uploaded file to target directory
    if ($upload_ok && move_uploaded_file($_FILES["blogImg"]["tmp_name"], $target_file)) {
     
        $sql = "INSERT INTO blog (blogEntry, createdBy, updatedDate, blogImg)
        VALUES ('$blogEntry', '$createdBy', '$updatedDate', '$target_fileDB')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New blog record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
mysqli_close($conn);
?>

