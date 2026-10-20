<?php
//include db config
session_start();
include("config/config.php");

// Get query string parameters
$productID = isset($_GET['productID']) ? htmlspecialchars($_GET['productID']) : '';
$reservationID = isset($_GET['rd-id']) ? htmlspecialchars($_GET['rd-id']) : '';
$productName = isset($_GET['productName']) ? htmlspecialchars($_GET['productName']) : '';
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
<header></header>
<!-- User Nav section-->
<?php include("includes/userNav.php"); ?>
<!-- Main container for sticky footer -->
<div class="container">
  <!-- Navigation Menu -->		
  <?php include("includes/topNav.php"); include("userAuth/modalForm.php"); ?>
  <main>
    <h2 style="text-align: center;">Review</h2>
    <div class="rowform">
      <form action="reviewProcess.php" method="post" name="reviewForm">
        <input type="hidden" name="reservationID" value="<?php echo $reservationID; ?>">
        <input type="hidden" name="productID" value="<?php echo $productID; ?>">
        <p>Product Name: <strong><?php echo $productName; ?></strong></p>
        <p>Email : <input type="email" name="email" id="email" required></p>
        <p>Order date : <input type="date" id="orderdate" name="orderdate" required></p>
          <p>Food Type : <input type="checkbox" name="foodtype[]" value="breakfast"> Breakfast
            <input type="checkbox" name="foodtype[]" value="lunch"> Lunch
            <input type="checkbox" name="foodtype[]" value="dinner"> Dinner
          <p>Order type : <input type="radio" name="orderType" value="Take Away" id="takeaway" checked>
            <label for="takeaway"> Takeaway</label>
            <input type="radio" name="orderType" value="Dine In" id="dineIn">
            <label for="dineIn"> Dine-In</label>
          </p>
          <p>Branch : <select name="branch" required>
              <option value="">- Please Select -</option>
              <option value="Kota Kinabalu">Kota Kinabalu</option>
              <option value="Sandakan">Sandakan</option>
              <option value="Batu Pahat">Batu Pahat</option>
            </select></p>
        <p>Review: <br><textarea id="review" name="review" rows="4" cols="50" required></textarea></p>
        <p>
          <label for="rating">Rating (1-5):</label>
          <input type="range" name="rating" id="rating" min="1" max="5">
        </p>
        <input type="submit" value="Submit">
        <input type="reset" value="Reset">
      </form>         
    </div>
  </main>
</div>
<footer class="footer">
  <p><small><i>Copyright &copy; 2024 FCI</i></small></p>
</footer>
</body>
</html>
