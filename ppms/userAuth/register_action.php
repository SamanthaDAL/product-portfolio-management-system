<?php
include("../config/config.php");
?>
<!DOCTYPE html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" type="text/css" href="newstyle.css">
</head>
<body>
<?php

//STEP 1: Form data handling using mysqli_real_escape_string function to escape special characters for use in an SQL query,
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    //Validate pwd and confrimPwd
    if ($userPwd !== $confirmPwd) {
        die("Password and confirm password do not match.");
    }

    //STEP 2: Check if userEmail already exist
	$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";	
	$result = mysqli_query($conn, $sql);
	
    if (mysqli_num_rows($result) == 1) {
		echo "<p ><b>Error: </b> User exist, please register a new user</p>";		
	} else {
		// User does not exist, insert new user record, hash the password		
		$pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT)); 
		//echo $pwdHash;
		$sql = "INSERT INTO user (userName, userEmail, userPwd ) VALUES ('$userName','$userEmail', '$pwdHash')";
		if (mysqli_query($conn, $sql)) {
			//echo "<p>New user record created successfully. Welcome <b>".$userName."</b></p>";
			echo '<script type="text/javascript">		
			alert("Registration successful, please Login!");
			</script>';		
			echo '<script type="text/javascript">
            window.location.href = "' . BASE_URL . 'index.php";
        	</script>';
    	exit(); // Make sure to exit after performing the redirection		
			//header("location:http://localhost/ppms/index.php"); 
			//header('Location: ' . BASE_URL . '/index.php');
		} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}	
	}
}
mysqli_close($conn);
?>
</body>
</html>