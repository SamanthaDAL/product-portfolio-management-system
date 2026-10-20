<?php
session_start();
include_once("config/config.php");
?>

<div class="row">
    <p style="margin: 15px;">/ Search Results</p>
</div>

<?php 
//1.Validate the input search text and split it into keywords using explode function.
if(!empty($_POST["search_text"])) {
    $search_text = trim($_POST["search_text"]);
}
 $keywords = explode(" ", $search_text);

//2.Initialize the SQL query search conditions using an array.
$search_conditions = [];
$count = 0;
foreach ($keywords as $keyword) {
  if (!empty($keyword)) {
    $search_conditions[] = "productName LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%'";
    echo "Search conditions array $count : " . $search_conditions[$count] . "<br>";
    $count++;
  }  
}

//3.Execute the SQL query based on search conditions and display the results.
// Combine conditions with OR using implode function
$sql = "SELECT * FROM product WHERE " . implode(" OR ", $search_conditions);
echo "SQL Using implode function : " . $sql ." <br><br>";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) { //1m
  while ($row = mysqli_fetch_assoc($result)) { //1m         
   echo "&nbsp;&nbsp;&nbsp;&nbsp;" . "<a href='" . BASE_URL . "portfolioDetail.php?id={$row['productID']}'>{$row['productName']}</a><br>";         
   //echo htmlspecialchars($row['productName']) . "<br>";
}
  } else {
   echo "<p>Sorry, no result for htmlspecialchars($search_text) "; 
    }

    echo "<br><a href='" . BASE_URL . "'>Back to PPMS</a>";
?>


