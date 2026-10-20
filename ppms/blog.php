<?php
// Include database configuration
session_start();
include("config/config.php");

// Set the number of items per page
$items_per_page = 3;

// Get the current page number, default to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting point for the query
$start_from = ($current_page - 1) * $items_per_page;

// Get the search query from the URL
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Construct the SQL query with a WHERE clause if a search query is provided
if ($search_query) {
    $query = "SELECT blogEntry, blogImg FROM blog WHERE blogEntry LIKE '%$search_query%' LIMIT $start_from, $items_per_page";
    $count_query = "SELECT COUNT(*) FROM blog WHERE blogEntry LIKE '%$search_query%'";
} else {
    $query = "SELECT blogEntry, blogImg FROM blog LIMIT $start_from, $items_per_page";
    $count_query = "SELECT COUNT(*) FROM blog";
}

$result = mysqli_query($conn, $query);

// Count the total number of rows for pagination
$count_result = mysqli_query($conn, $count_query);
$row = mysqli_fetch_row($count_result);
$total_entries = $row[0];
$total_pages = ceil($total_entries / $items_per_page); // Total pages
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
  <style>
    #blogtable {
      width: 100%;
      table-layout: fixed;
      border-collapse: collapse;
    }

    #blogtable th,
    #blogtable td {
      width: calc(100% / 3);
      text-align: center;
      border: 1px solid #ddd;
      padding: 8px;
      vertical-align: top;
    }

    #blogtable th {
      background-color: #e0e0e0;
    }

    img {
      max-width: 100%;
      height: auto;
    }

    .pagination {
      text-align: center;
      margin-top: 20px;
    }

    .pagination a {
      margin: 0 5px;
      padding: 8px 16px;
      text-decoration: none;
      background-color: #f1f1f1;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .pagination a:hover {
      background-color: #ddd;
    }
  </style>
</head>

<body>
  <header></header>
  <?php include("includes/userNav.php"); ?>
  <div class="container">
    <?php
    include("includes/topNav.php");
    include("userAuth/modalForm.php");
    ?>
    <main>
      <h2 style="text-align: center;">Blog</h2>
      <div class="section" style="text-align: center;">
        <form method="get" action="">
          Search Blog: <input type="search" name="search" id="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          <input type="submit" value="Search">
        </form>
      </div>
      <div class="section">
        <table width="100%" border="1" id="blogtable">
          <!-- First row: Article label -->
          <tr>
            <th style="background-color: #e0e0e0;text-align: center;" colspan="3">Article</th>
          </tr>
          <!-- Second row: Blog entries -->
          <tr>
            <?php
            // Display blog entries
            $entriesCount = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<td>" . htmlspecialchars($row['blogEntry']) . "</td>";
              $entriesCount++;
            }

            // Fill empty cells if fewer than 3 entries
            while ($entriesCount < 3) {
              echo "<td></td>";
              $entriesCount++;
            }
            ?>
          </tr>
          <!-- Third row: Image label -->
          <tr>
            <th style="background-color: #e0e0e0;text-align: center;" colspan="3">Image</th>
          </tr>
          <!-- Fourth row: Blog images -->
          <tr>
            <?php
            // Reset result pointer and fetch images
            mysqli_data_seek($result, 0);
            $imagesCount = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              if (!empty($row['blogImg'])) {
                echo "<td><img src='" . htmlspecialchars($row['blogImg']) . "' alt='Blog Image' style='width:100%;height:auto;'></td>";
                $imagesCount++;
              }
            }

            // Fill empty cells if fewer than 3 images
            while ($imagesCount < 3) {
              echo "<td></td>";
              $imagesCount++;
            }
            ?>
          </tr>
        </table>
      </div>

      <!-- Pagination Links -->
      <div class="pagination">
        <?php
        // Previous page link
        if ($current_page > 1) {
          echo "<a href='?page=" . ($current_page - 1) . "&search=" . urlencode($search_query) . "'>Previous</a>";
        }

        // Page number links
        for ($page = 1; $page <= $total_pages; $page++) {
          echo "<a href='?page=" . $page . "&search=" . urlencode($search_query) . "'>" . $page . "</a>";
        }

        // Next page link
        if ($current_page < $total_pages) {
          echo "<a href='?page=" . ($current_page + 1) . "&search=" . urlencode($search_query) . "'>Next</a>";
        }
        ?>
      </div>
    </main>
  </div>

  <footer class="footer">
    <p>Copyright &copy; 2024 FCI</p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
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

    function openLoginPopup() {
      document.getElementById("login-popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeLoginPopup() {
      document.getElementById("login-popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }

    function openRegPopup() {
      document.getElementById("reg-popup").style.display = "block";
      document.getElementById("overlay").style.display = "block";
    }

    function closeRegPopup() {
      document.getElementById("reg-popup").style.display = "none";
      document.getElementById("login-popup").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  </script>
</body>

</html>
