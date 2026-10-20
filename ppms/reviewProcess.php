<?php
session_start();
include("config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>My Product Portfolio Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/newstyle.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="includes/modalAuth.js"></script>
</head>
<?php 

?>
<body>
    <header>
        <!-- <h1>Home</h1> 	 -->
        <!--<img class="image" src="img/foodblog.png" width="100%" height="35%">-->
    </header>
    <?php include("includes/userNav.php"); ?>
    <img class="image" src="img/foodblog.png" width="100%" height="35%">
    <!-- Main container for sticky footer -->
    <div class="container">
        <!-- Navigation Menu -->
        <?php
        include(__DIR__ . "/includes/topnav.php");
        ?>
        <main>
            <h2 style="text-align: center;">Review</h2>
            <div class="rowform">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                 // Sanitize and retrieve inputs
                 $email = htmlspecialchars($_POST['email']);
                 $reservationID = htmlspecialchars($_POST['reservationID']);
                 $productID = htmlspecialchars($_POST['productID']);
                 $reviewText = htmlspecialchars($_POST['review']);
                 $rating = htmlspecialchars($_POST['rating']); 
                 $reviewDate = htmlspecialchars($_POST['orderdate']);
                 
                 // Get the food types, order type, and branch
                 $foodTypes = isset($_POST['foodtype']) ? implode(", ", $_POST['foodtype']) : "None";
                 $orderType = htmlspecialchars($_POST['orderType']);
                 $branch = htmlspecialchars($_POST['branch']);
                 
                 // Concatenate the review text with additional details
                 $reviewText = $reviewText . "\nDetails:\nFood Type: " . $foodTypes . "\nOrder Type: " . $orderType . "\nBranch: " . $branch;

                // Get userID from user table based on userEmail
                $stmtUser = $conn->prepare("SELECT userID FROM user WHERE userEmail = ?");
                $stmtUser->bind_param("s", $email);
                $stmtUser->execute();
                $resultUser = $stmtUser->get_result();

                if ($resultUser->num_rows > 0) {
                    $row = $resultUser->fetch_assoc();
                    $userID = $row['userID'];

                    // Insert review into the review table
                    $stmtReview = $conn->prepare("INSERT INTO review (reservationID, reviewText, rating, productID, reviewBy, reviewDate) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmtReview->bind_param("isiiis", $reservationID, $reviewText, $rating, $productID, $userID, $reviewDate);

                    if ($stmtReview->execute()) {
                        $formattedOrderDate = date("d/m/Y", strtotime($reviewDate));
                        echo "<h2>Thank You For Your Review</h2>";
                        echo "<p><strong>Email:</strong> $email</p>";
                        echo "<p><strong>Order Date:</strong> $formattedOrderDate</p>";
                        echo "<p><strong>Food Types:</strong> $foodTypes</p>";
                        echo "<p><strong>Order Type:</strong> $orderType</p>";
                        echo "<p><strong>Branch:</strong> $branch</p>";
                        echo "<p><strong>Review:</strong> $reviewText</p>";
                        echo "<p><strong>Rating:</strong> $rating</p>";
                        
                    } else {
                        echo "<h2>Error submitting your review. Please try again later.</h2>";
                    }

                    $stmtReview->close();
                } else {
                    echo "<h2>Error: Email not found in the system.</h2>";
                }

                $stmtUser->close();
                $conn->close();
            }
            ?>
            </div>
        </main>
    </div>
    <p></p>
    <footer class="footer">
        <p><small><i>Copyright &copy; 2024 FCI</i></small></p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll(".topnav a");
            const currentPath = window.location.pathname;

            navLinks.forEach(link => {
                if (link.href.includes(currentPath)) {
                    link.classList.add("active");
                } else {
                    link.classList.remove("active");
                }
            });
        });

        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
    </script>
</body>

</html>