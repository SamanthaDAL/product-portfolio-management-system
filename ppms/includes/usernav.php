<div class="usernav">
    <!-- Logo -->
    <div class="logo-container">
        <a href="<?php echo BASE_URL; ?>">
            <img src="<?php echo BASE_URL; ?>img/logo.jpeg" alt="Logo" class="logo">
        </a>
    </div>

    <!-- Search Form -->
    <div class="search-container">
        <form action="<?php echo BASE_URL; ?>search.php" method="post">
            <input type="search" placeholder="Search product" name="search_text" size="50" required>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <!-- User Links -->
    <div class="user-links">
        <?php if (isset($_SESSION["UID"])) { ?>
            <span>Welcome, <b><?php echo $_SESSION["userName"]; ?></b></span>
            <a href="<?php echo BASE_URL; ?>userAuth/logout.php" class="cart-button" title="Logout">
                <i class="fa fa-sign-out" style="font-size:24px;" alt="Logout"></i>
            </a>
        <?php } else { ?>
            <a href="javascript:void(0);" onclick="openLoginPopup()" class="cart-button">
                <i class="fa fa-sign-in" style="font-size:24px;" title="Login"></i>
            </a>
        <?php } ?>
        <?php
        echo '<a href="cart_action.php" title="My Cart"><i class="fa fa-shopping-cart" style="font-size:24px"></i></a> ';
        if (isset($_SESSION["cart_item"])) {
            $countItem = count($_SESSION["cart_item"]);
            echo "<b>($countItem)</b>&nbsp;</p>";
        } else {
            echo "<b>(0)&nbsp;</b></p>";
        } ?>
    </div>
</div>