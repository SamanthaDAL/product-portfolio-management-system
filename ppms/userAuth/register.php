<!DOCTYPE html>
<html>
<head>
<title>Registration</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" type="text/css" href="mystyle.css" media="screen" />
</head>
<body>
<header>
<div class="header">
	<h1>mySystem | User Registration </h1>
</div>
</header>
<main>
<form action="register_action.php" method="post">
	<label for="userName">Username:</label>
	<input type="text" id="userName" name="userName" required><br><br>

	<label for="userEmail">User Email:</label>
	<input type="email" id="userEmail" name="userEmail" required><br><br>

	<label for="userPwd">Password:</label>
	<input type="password" id="userPwd" name="userPwd" required maxlength="8"><br><br>

	<label for="userPwd">Confirm Password:</label>
	<input type="password" id="confirmPwd" name="confirmPwd" required><br><br>

	<input type="submit" value="Register">
	<input type="reset" value="Reset"></br>
</form>
</main>
<footer>
</footer>
</body>
</html>