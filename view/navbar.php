<link rel="stylesheet" href="assets/css/main.css" />

<nav class="admin-navbar">

    <div class="nav-links">

        <!-- <a href="public.php?page=userDashboard" class="logo"> <img src="view/images/bg.jpg" /></a> -->
        <a href="public.php?page=userDashboard"> Book Details</a>
        <a href="#about"> About</a>
        <!-- <a href="public.php?page=users">👥 Users</a> -->
         <?php
           echo '<a href="public.php?page=cart" id="num">Cart 🛒 <span id="cartCount">' . intval($cartCount) . '</span></a>';
        echo ' <a href="public.php?page=like" id="num">Likes ❤️ <span id="likeCount">' . intval($likeCount) . '</span></a>';
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
<form method="get" action="/MVC-project/MVC_project/public.php">
        <input type="hidden" name="page" value="search">
        <input type="text" name="q" placeholder="Search books...">
        <button type="submit">🔍 Search</button>
    </form>