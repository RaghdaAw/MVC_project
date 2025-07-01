<link rel="stylesheet" href="assets/css/main.css" />
<head>
   <title>Bookly Library</title>
</head>
<nav class="admin-navbar">
    <div class="logo">📚 Admin Panel</div>
    <div class="nav-links">
        <a href="public.php?page=books">📖 All Books</a>
        <a href="public.php?page=addBook">➕ Add Book</a>
        <a href="public.php?page=users">👥 Users</a>
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