<?php
//include db config
include("../../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);

    // Another example to retrieve the existing product data using prepared statement
    $sql = "SELECT * FROM product WHERE productID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $productID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $productName = $row['productName'];
        $productPrice = $row['productPrice'];
        $productQty = $row['productQty'];
        $productImg = $row['productImg'];
    } else {
        echo "Product not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle Product Update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $productQty = $_POST['productQty'];
    $productPrice = $_POST['productPrice'];

    $uploadDir = '../../../uploads/';
    $productImg = null;

    // Check if a new image is uploaded
    if (isset($_FILES['productImg']) && $_FILES['productImg']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['productImg']['tmp_name'];
        $fileName = basename($_FILES['productImg']['name']);
        $targetPath = $uploadDir . $fileName;

        // Move the uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $image = $fileName;

            // Optional: Delete the old image if necessary
            $sql = "SELECT productImg FROM product WHERE productID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $productID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);

            if ($product && $product['productImg'] && file_exists($uploadDir . $product['productImg'])) {
                unlink($uploadDir . $product['productImg']); // Deletes the old image file
            }
            mysqli_stmt_close($stmt);
            echo $productImg;
        }
    }

    if ($image) {
        //directory saved to DB
        $productImg = "uploads/" . $image;
        echo $productImg;
        $sql = "UPDATE product SET productName = ?, productPrice = ?, productQty = ?, productImg = ? WHERE productID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sdisi", $productName, $productPrice, $productQty, $productImg, $productID);
    } else {
        $sql = "UPDATE product SET productName = ?, productPrice = ?, productQty = ? WHERE productID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sdii", $productName, $productPrice, $productQty, $productID);
    }

    // Execute query
    if (mysqli_stmt_execute($stmt)) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Redirect or display a success message
    header("Location: productList.php");
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
    <title>Product Form</title>
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
        <h2 style="text-align: center;">Edit Product ID : <?= $productID ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="productID" value="<?= isset($productID) ? htmlspecialchars($productID) : 'NONE'; ?>">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($productName) ?>" required><br><br>
                <label for="productPrice">Product Price:</label>
                <input type="text" id="productPrice" name="productPrice" value="<?= htmlspecialchars($productPrice) ?>" required><br><br>
                <label for="productPrice">Product Quantity:</label>
                <input type="text" id="productQty" name="productQty" value="<?= htmlspecialchars($productQty) ?>" required><br><br>
                <label for="prod_image">Product Image:</label><br>
                <img src="<?= BASE_URL . '/' . htmlspecialchars($productImg) ?>" style="width:150px;height:150px;text-align: center;"><br><br>
                <input type="file" id="productImg" name="productImg" accept="image/*"><br><br>
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