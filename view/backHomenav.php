<link rel="stylesheet" href="/view/assets/css/main.css" />

<nav class="user-navbar">

    <div class="nav-links">
        <a href="public.php?page=userDashboard">Home</a>
        <?php
        echo '<a href="public.php?page=cart" id="num">🛒 <span id="cartCount">' . intval($cartCount ?? 0) . '</span></a>';
        echo ' <a href="public.php?page=like" id="num">❤️ <span id="likeCount">' . intval($likeCount ?? 0) . '</span></a>';
        ?>
        <a href="public.php?page=logout">🚪 Logout</a>
    </div>

    <div class="user">

        <?php

        if (isset($_SESSION['username'])) {
            echo "👋 Welcome, " . htmlspecialchars($_SESSION['username']);
        } else {
            echo "Not logged in";
        }
        ?>

    </div>


</nav>

<form class="search-form" method="get" action="./public.php">
    <input type="hidden" name="page" value="search">
    <input class="search-books" type="text" name="q" placeholder="Search books...">
    <button class="search-button" type="submit">🔍 Search</button>
</form>