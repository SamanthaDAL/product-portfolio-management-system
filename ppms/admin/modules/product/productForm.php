<?php
include(dirname(__DIR__, 3) . '/config/config.php');
// Query to get categoryID and categoryName
$sql = "SELECT categoryID, categoryName FROM category";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" type="text/css" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
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

  <?php include '../../includes/sideNav.php'; ?>
  <div class="main">
    <h2>Create Product</h2>

    <form action="insertProduct.php" method="POST"
enctype="multipart/form-data">
<label for="productName">Product Name:</label><br>
<input type="text" id="productName" name="productName"
required><br><br>
<label for="productQty">Product Quantity:</label><br>
<input type="number" id="productQty" name="productQty"
required><br><br>
<label for="productPrice">Product Price:</label><br>
<input type="number" id="productPrice" name="productPrice"
min="0.01" step="0.01" required><br><br>

<!--
<label for="categoryID">Product Category:</label><br>
<select id="categoryID" name="categoryID" required>
<option value="">Select Category</option>
<option value="1">Books</option>
<option value="2">Coffee</option>
<option value="3">Food</option>
</select><br><br>
-->

<label for="categoryID">Product Category:</label><br>
<select id="categoryID" name="categoryID" required>
<option value="">Select Category</option>
    <?php
    // Check if the query returned results
    if ($result->num_rows > 0) {
        // Loop through each row and create an <option> element
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['categoryID'] . '">' . $row['categoryName'] . '</option>';
        }
    } else {
        echo '<option value="">No categorys found</option>';
    }
    ?>
</select><br><br>

<!-- Product Image -->
<label for="productImg">Product Image:</label><br>
<input type="file" id="productImg" name="productImg"
accept="image/*" required><br><br>
<button type="submit">Submit</button>
</form>

  </div>
  <script>
    /* JS for dropdown content */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
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
