<?php
//include db config
session_start();
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>My Korean Cafe Blog</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/newstyle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<header>
		<!-- <h1>Home</h1> 	
		<img class="image" src="img/coffeeblog.png"> -->
	</header>
	<!-- User Nav section-->
	<?php
		include("includes/userNav.php");
	?>
	<!-- Main container for sticky footer -->
	<div class="container">
		<!-- Navigation Menu -->
		<?php
		include("includes/topNav.php");
		?>
		<!-- Place banner under menu for bigger space -->
		<img class="image" src="img/foodblog.png"> 

		<!-- Login Popup -->
		<div id="login-popup" class="login-popup">
			<span class="close-btn" onclick="closeLoginPopup()">&times;</span>
			<h3>User Login </h3>
			<form action="userAuth/login_action.php" method="post">
				<label for="userEmail">User Email:</label><br>
				<input type="email" id="userEmail" name="userEmail" required><br><br>
				<label for="userPwd">Password:</label><br>
				<input type="password" id="userPwd" name="userPwd" required maxlength="8" autocomplete="off"><br><br>
				<input type="submit" value="Login">
				<input type="reset" value="Reset"></br>
			</form>
			<p><a href="javascript:void(0);" onclick="openRegPopup();">| Registration </a> | Forgot Password |</p>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeLoginPopup();"></div>
		<!-- End Login Popup -->
		<!-- Registration Popup -->
		<div id="reg-popup" class="reg-popup">
			<span class="close-btn" onclick="closeRegPopup()">&times;</span>
			<h3>User Registration </h3>
			<form action="userAuth/register_action.php" method="post">
				<label for="reguserName">Username:</label><br>
				<input type="text" id="reguserName" name="userName" required><br><br>
				<label for="reguserEmail">User Email:</label><br>
				<input type="email" id="reguserEmail" name="userEmail" required><br><br>
				<label for="reguserPwd">Password:</label><br>
				<input type="password" id="reguserPwd" name="userPwd" required maxlength="8"><br><br>
				<label for="regconfirmPwd">Confirm Password:</label><br>
				<input type="password" id="regconfirmPwd" name="confirmPwd" required><br><br>
				<input type="submit" value="Register">
				<input type="reset" value="Reset"></br>
			</form>
		</div>
		<!-- Overlay -->
		<div id="overlay" class="overlay" onclick="closeRegPopup()"></div>
		<!-- End Registration Popup -->
		<main>
			<!-- <h2 style="text-align: center;">Home</h2> -->
			<div class="row">
				<div class="col-left">
					<img src="img/profile.jpg" alt="avatar image" style="width:150px;height:200px;">
				</div>
				<div class="col-right">
					<h3>About Me</h3>
					<table border="1" width="100%" id="blogtable">
						<tr>
							<td width="150">Name</td>
							<td>Lam Wai Sim</td>
						</tr>
					</table>
					<div>
						<h3>My Daily Quote</h3>
						<table width="100%">
							<tr>
								<td>Join me in my Korean foodie journey...</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</main>
	</div>
	<footer class="footer">
		<p>Copyright &copy; 2024 FCI</p>
	</footer>
	<script>
		//JS function called on small screen
		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}

		//menu navigation active, upon page load
		document.addEventListener("DOMContentLoaded", function() {
			const navLinks = document.querySelectorAll(".topnav a");
			const currentPath = window.location.pathname;

			// Remove any existing 'active' class from all links initially
			navLinks.forEach(link => link.classList.remove("active"));

			// Add 'active' class to the link that matches the current path
			navLinks.forEach(link => {
				const linkPath = new URL(link.href).pathname; // Get path part of link's URL
				if (linkPath === currentPath) {
					link.classList.add("active");
				}
			});
		});

		//Login & Reg Form Popup
		function openLoginPopup() {
			document.getElementById("login-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeLoginPopup() {
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}

		function openRegPopup() {
			document.getElementById("reg-popup").style.display = "block";
			document.getElementById("overlay").style.display = "block";
		}

		function closeRegPopup() {
			document.getElementById("reg-popup").style.display = "none";
			document.getElementById("login-popup").style.display = "none";
			document.getElementById("overlay").style.display = "none";
		}
	</script>
</body>

</html>