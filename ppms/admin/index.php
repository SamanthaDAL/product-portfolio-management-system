<?php
session_start();
include("../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ADMIN_BASE_URL; ?>/css/admin.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <!-- Side Navigation -->
    <?php include 'includes/sideNav.php'; ?>

    <!-- Main Container -->
    <div class="main">
        <h2>Admin Panel Dashboard</h2>
    </div>

    <!-- Login Popup -->
    <div id="login-popup" class="login-popup">
        <span class="close-btn" onclick="closeLoginPopup()">&times;</span>
        <h3>Admin Login</h3>
        <form action="userAuth/login_action.php" method="post">
            <label for="adminEmail">Admin Email:</label><br>
            <input type="email" id="adminEmail" name="userEmail" required><br><br>
            <label for="adminPwd">Password:</label><br>
            <input type="password" id="adminPwd" name="userPwd" required maxlength="8" autocomplete="off"><br><br>
            <input type="submit" value="Login">
            <input type="reset" value="Reset"></br>
        </form>
    </div>
    <!-- Overlay -->
    <div id="overlay" class="overlay" onclick="closeLoginPopup()"></div>

    <footer class="footer">
        <p>&copy; 2024 Admin Panel</p>
    </footer>

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
