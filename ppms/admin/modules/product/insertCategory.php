<?php
//include db config
include("../../../config/config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];
    $categoryDesc = $_POST['categoryDesc'];
    $createDate = $_POST['createDate'];

        $sql = "INSERT INTO category (categoryName, categoryDesc, createDate)
        VALUES ('$categoryName', '$categoryDesc', '$createDate')";
    
        if (mysqli_query($conn, $sql)) {
        echo "<br>New category record created successfully";
        echo "<br><a href='" . ADMIN_BASE_URL . "'>Back to Admin Panel</a>";
        } else {
        echo "<br>Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        } else {
        echo "Sorry, there was an error uploading your file.";
    
}
mysqli_close($conn);
?>

