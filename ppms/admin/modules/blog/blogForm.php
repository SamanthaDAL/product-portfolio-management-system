<?php
include(dirname(__DIR__, 3) . '/config/config.php');
// Query to get userID and userName
$sql = "SELECT userID, userName FROM user";
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
    <h2>Create Blog</h2>

    <form action="insertBlog.php" method="POST"
enctype="multipart/form-data">
<label for="blogEntry">Blog Entry:</label><br>
<input type="text" id="blogEntry" name="blogEntry"
required><br><br>

<label for="createdBy">Created By:</label><br>
<select id = "createdBy" name="createdBy" required>
<option value="">Select User</option>
    <?php
    // Check if the query returned results
    if ($result->num_rows > 0) {
        // Loop through each row and create an <option> element
        while($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['userID'] . '">' . $row['userName'] . '</option>';
        }
    } else {
        echo '<option value="">No users found</option>';
    }
    ?>
</select><br><br>

<label for="updatedDate">Updated Date:</label><br>
<input type="date" id="updatedDate" name="updatedDate"
required><br><br>

<!-- Blog Image -->
<label for="blogImg">Blog Image:</label><br>
<input type="file" id="blogImg" name="blogImg"
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
