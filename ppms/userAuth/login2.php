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
	<h1>mySystem | User Login</h1>
</div>
</header>
<main>
<form action="login_actionX.php" method="post">
	<label for="userEmail">User Email:</label>
	<input type="email" id="userEmail" name="userEmail" required><br><br>	
	<label for="userPwd">Password:</label>
	<input type="password" id="userPwd" name="userPwd" required maxlength="50"> 
    &nbsp; <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()"> Show Password <br><br>
    <button type="submit" onclick="validatePassword()">Login</button>
	<input type="reset" value="Reset"></br>	
</form>
</main>
<footer>
</footer>

<script> 
    function validatePassword() {
        var password = document.getElementById('userPwd').value;
        var isValid = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&^_#]{50,}$/.test(password);

        if (!isValid) {
            alert('Password does not meet the specified pattern for a strong password.');
        } else {
            alert('Login successful!');
        }
    }

    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('userPwd');
        var showPasswordCheckbox = document.getElementById('showPassword');

        if (showPasswordCheckbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
</script>

<!-- 
Password validation:
At least one lowercase letter ((?=.*[a-z]))
At least one uppercase letter ((?=.*[A-Z]))
At least one digit ((?=.*\d))
At least one special character ((?=.*[@$!%*?&]))
Minimum length of 8 characters ({8,}) -->
</body>
</html>