<?php
session_start();
include("config/config.php");

// Check login
if (!isset($_SESSION["UID"])) {
    header("location:userAuth/login.php");
}
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
        <p style="margin: 15px;"><i class="fa fa-shopping-cart" style="font-size:24px"></i> / Checkout Information</p>
        <div class="section">
            <?php
            if (!empty($_GET["price"])) {
                $order_amt = $_GET["price"];
                $order_status = 1; // 1= New, 2=Process, 3= Completed

                // Insert into reservation table
                $sql = "INSERT INTO reservation (status, orderAmt, userID)
                        VALUES ('" . $order_status . "','" . $order_amt . "','" . $_SESSION["UID"] . "')";

                if (mysqli_query($conn, $sql)) {
                    echo "<p>&nbsp;&nbsp;&nbsp;&nbsp; New customer order record has the reservation id: " . mysqli_insert_id($conn) . "</p>";
                    $order_id = mysqli_insert_id($conn);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

                foreach ($_SESSION["cart_item"] as $item) {
                    // Insert into reservation_detail table
                    $sql2 = "INSERT INTO reservation_detail (reservationID, productID, orderQuantity)
                             VALUES ('" . $order_id . "','" . $item["prodID"] . "','" . $item["quantity"] . "')";

                    if (mysqli_query($conn, $sql2)) {
                        echo "<p>&nbsp;&nbsp;&nbsp;&nbsp; Reservation detail record has the Line id: " . mysqli_insert_id($conn) . "</p><br>";
                        $line_id = mysqli_insert_id($conn);

                        // Update product quantity in the product table
                        $product_id = $item["prodID"];
                        $quantity_bought = $item["quantity"];
                        $update_sql = "UPDATE product 
                                       SET productQty = productQty - $quantity_bought 
                                       WHERE productID = $product_id";
                        if (!mysqli_query($conn, $update_sql)) {
                            echo "Error updating product quantity: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
            }
            mysqli_close($conn);
            unset($_SESSION["cart_item"]); //unset cart
            ?>
        </div>
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
