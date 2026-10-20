<?php
// Include db config
include("../../../config/config.php");

// Check if ID is provided
if (isset($_GET['id'])) {
    $categoryID = intval($_GET['id']);

    // Retrieve the existing category data using prepared statement
    $sql = "SELECT * FROM category WHERE categoryID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $categoryID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $categoryName = $row['categoryName'];
        $categoryDesc = $row['categoryDesc']; // This is where the description is fetched
        $createDate = $row['createDate'];
    } else {
        echo "Category not found.";
        exit;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
    exit;
}

// Handle category update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];
    $categoryDesc = $_POST['categoryDesc'];
    $createDate = $_POST['createDate'];

    // Prepare and execute the update query
    $sql = "UPDATE category SET categoryName = ?, categoryDesc = ?, createDate = ? WHERE categoryID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $categoryName, $categoryDesc, $createDate, $categoryID);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect after successful update
        header("Location: categoryList.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
    <title>Category Form</title>
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
        <h2 style="text-align: center;">Edit Category ID: <?= htmlspecialchars($categoryID) ?></h2>
        <div class="rowform">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="categoryID" value="<?= htmlspecialchars($categoryID) ?>">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" name="categoryName" value="<?= htmlspecialchars($categoryName) ?>" required><br><br>
                <label for="categoryDesc">Category Description:</label>
                <input type="text" id="categoryDesc" name="categoryDesc" value="<?= htmlspecialchars($categoryDesc) ?>" required><br><br>
                <label for="createDate">Create Date:</label>
                <input type="datetime-local" id="createDate" name="createDate" value="<?= htmlspecialchars(date("Y-m-d\TH:i", strtotime($createDate))) ?>" required><br><br>
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
