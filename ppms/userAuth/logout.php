<?php
session_start();
include_once("../config/config.php");

if(isset($_SESSION["UID"])){
	echo '<script type="text/javascript">		
			alert("Logout successful!");
	</script>';
	unset($_SESSION["UID"]);
	unset($_SESSION["userName"]);	
	echo '<script type="text/javascript">
			window.location.href = "' . BASE_URL . 'index.php";
    </script>';
	//header('Location: ' . BASE_URL . 'index.php');
}	
?>