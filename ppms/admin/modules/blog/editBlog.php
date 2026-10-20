<?php
//include db config
include("../../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $blogID = intval($_GET['id']);

    // Another example to retrieve the existing blog data using prepared statement
    $sql = "SELECT * FROM blog WHERE blogID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $blogEntry = $row['blogEntry'];
        $updatedDate = $row['updatedDate'];
        $blogImg = $row['blogImg'];
    } else {
        echo "Blog not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle blog Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blogEntry = $_POST['blogEntry'];
    $updatedDate = $_POST['updatedDate'];

    $uploadDir = '../../../uploads/';
    $blogImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['blogImg']) && $_FILES['blogImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['blogImg']['tmp_name'];
        $fileName = basename($_FILES['blogImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT blogImg FROM blog WHERE blogID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $blogID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $blog = mysqli_fetch_assoc($result);

            if ($blog && $blog['blogImg'] && file_exists($uploadDir . $blog['blogImg'])) {
                unlink($uploadDir . $blog['blogImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $blogImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $blogImg = "uploads/" . $image;
        echo $blogImg;
        $sql = "UPDATE blog SET blogEntry = ?, updatedDate = ?, blogImg = ? WHERE blogID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $blogEntry, $updatedDate, $blogImg, $blogID);
    } else {
        $sql = "UPDATE blog SET blogEntry = ?, updatedDate = ? WHERE blogID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $blogEntry, $updatedDate, $blogID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Blog updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: blogList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Blog Form</title>
</head>

<body>
<header>
    <div class="topNav">
        <img src="<?php echo ADMIN_BASE_URL; ?>/img/logo.jpeg" alt="Logo">
        <?php if (isset($_SESSION["UID"])) { ?>
            <span>Welcome, <b><?php echo $_SESSION["userName"]; ?></b></span>
            <a href="<?php echo ADMIN_BASE_URL; ?>userAuth/logout.php" class="logout-button" title="Logout">
                <i class="fa fa-sign-out" style="font-size:24px;" alt="Logout"></i>
            </a>
        <?php } else { ?>
            <a href="javascript:void(0);" onclick="openLoginPopup()" class="login-button">
                <i class="fa fa-sign-in" style="font-size:24px;" title="Login"></i>
            </a>
        <?php } ?>
    </div>
</header>

    <?php
    include '../../includes/sideNav.php';
    ?>

    <div class="main">
        <h2 style="text-align: center;">Edit blog ID : <?= $blogID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="blogID" value="<?= isset($blogID) ? htmlspecialchars($blogID) : 'NONE'; ?>">
                <label for="blogEntry">Blog Entry:</label>
                <input type="text" id="blogEntry" name="blogEntry" value="<?= htmlspecialchars($blogEntry) ?>" required><br><br>
                <label for="updatedDate">Updated Date:</label>
                <input type="date" id="updatedDate" name="updatedDate" value="<?= htmlspecialchars($updatedDate) ?>" required><br><br>
                <label for="blog_image">Blog Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($blogImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="blogImg" name="blogImg" accept="image/*"><br><br>
                <button type="submit">Update</button>

            </form>
        </div>
    </div>
    <script>
        //Login & Popup
		function openLoginPopup() {
			document.getElementById("login-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeLoginPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}

        // Dropdown content in sideNav
        const dropdown = document.getElementsByClassName("dropdown-btn");
        for (let i = 0; i < dropdown.length; i++) {
            dropdown[i].addEventListener("click", function () {
                this.classList.toggle("active");
                const dropdownContent = this.nextElementSibling;
                dropdownContent.style.display =
                    dropdownContent.style.display === "block" ? "none" : "block";
            });
        }
    </script>
</body>

</html>