<link rel="stylesheet" href="assets/css/main.css" />
 <title>Bookly Library</title>
<nav class="admin-navbar">

    <div class="nav-links">

        <a href="public.php?page=userDashboard" class="logo"> <img src="view/images/Media.jpg" /></a>
        <a href="public.php?page=userDashboard"> Book Details</a>
        <a href="#about"> About</a>
        <a href="public.php?page=login">🚪 Login</a>
        <a href="public.php?page=register">📝 Register</a>
    </div>

</nav>
<form method="get" action="./public.php">
        <input type="hidden" name="page" value="search">
        <input type="text" name="q" placeholder="Search books...">
        <button type="submit">🔍 Search</button>
    </form>