<link rel="stylesheet" href="assets/css/main.css" />
<<<<<<< HEAD
 <title>Bookly Library</title>
<nav class="admin-navbar">

    <div class="nav-links">

        <a href="public.php?page=userDashboard" class="logo"> <img src="view/images/Media.jpg" /></a>
        <a href="public.php?page=userDashboard"> Book Details</a>
        <a href="#about"> About</a>
=======

<nav class="user-navbar">

    <div class="nav-links">
<!--        <a href="public.php?page=userDashboard" class="logo"> <img src="/view/images/Media.jpeg" /></a>-->
        <a href="public.php?page=userDashboard">Home</a>
        <a href="#about"> About Us</a>
>>>>>>> origin/Yara
        <!-- <a href="public.php?page=users">👥 Users</a> -->
         <?php
           echo '<a href="public.php?page=cart" id="num">🛒 <span id="cartCount">' . intval($cartCount) . '</span></a>';
        echo ' <a href="public.php?page=like" id="num">❤️ <span id="likeCount">' . intval($likeCount) . '</span></a>';
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
<<<<<<< HEAD
<form method="get" action="./public.php">
=======

<div class="bookly-hello">
    <h1 class="bookly-title">BOOKLY</h1>
    <h3 class="newest-library">The Newest Online Library!</h3>
    <p>
        Bookly isn’t just about books — it’s about building a community where stories, ideas, and readers come together.
    </p>
    <p>
        Start your reading journey with us today!
    </p>
</div>


<form class="search-form" method="get" action="./public.php">
>>>>>>> origin/Yara
        <input type="hidden" name="page" value="search">
        <input class="search-books" type="text" name="q" placeholder="Search books...">
        <button class="search-button" type="submit">🔍 Search</button>
    </form>