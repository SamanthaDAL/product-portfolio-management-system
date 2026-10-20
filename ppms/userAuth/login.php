<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" type="text/css" href="mystyle.css" media="screen" />
</head>
<body>
<header>
<div class="header">
	<h1>PPMS | User Login</h1>
</div>
</header>
<main>
<form action="login_action.php" method="post">
	<label for="userEmail">User Email:</label>
	<input type="text" id="userEmail" name="userEmail" required><br><br>	
	<label for="userPwd">Password:</label>
	<input type="password" id="userPwd" name="userPwd" required><br><br>
	<input type="submit" value="Login">
	<input type="reset" value="Reset"></br>	
</form>
</main>
<footer>
</footer>
</body>
</html>