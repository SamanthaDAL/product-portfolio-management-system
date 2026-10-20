<?php
session_start();
include(dirname(__DIR__, 2) . "/config/config.php");
?>
<html>
<head>
    <title>Login Action</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" type="text/css" href="mystyle.css" media="screen" />
</head>
<body>
<?php
// Retrieve login values from login form
$userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
$userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);

// Query to check if the user exists
$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    // Verify the password
    if (password_verify($_POST['userPwd'], $row['userPwd'])) {
        echo '<script type="text/javascript">alert("Login successful!");</script>';

        // Set session variables
        $_SESSION["UID"] = $row["userID"];
        $_SESSION["userName"] = $row["userName"];
        $_SESSION["userRoles"] = $row["userRoles"];
        $_SESSION['loggedin_time'] = time();

        // Redirect based on user role
        if ($_SESSION["userRoles"] == 2) {
            echo '<script type="text/javascript">
                window.location.href = "' . BASE_URL . 'index.php";
            </script>';
        } else if ($_SESSION["userRoles"] == 1) {
            echo '<script type="text/javascript">
                window.location.href = "' . ADMIN_BASE_URL . '";
            </script>';
        }
        exit(); // Exit after redirection
    } else {
        // Incorrect password
        echo 'Login error: Incorrect email or password.<br>';
        echo '<a href="' . BASE_URL . 'index.php"> | Login |</a> <br>';
    }
} else {
    // User does not exist
    echo "Login error: User <b>$userEmail</b> does not exist. <br>";
    echo '<a href="' . BASE_URL . 'index.php"> | Login |</a> <br>';
}

// Close the database connection
mysqli_close($conn);
?>
</body>
</html>
