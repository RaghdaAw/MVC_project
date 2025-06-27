<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../model/LikeModel.php';

$userId = $_SESSION['user_id'] ?? null;
$cartCount = $userId ? CartModel::getCartItemCount($userId) : 0;
$likeCount = $userId ? LikeModel::getLikeCount($userId) : 0;
?>

<link rel="stylesheet" href="assets/css/main.css" />

<nav class="user-navbar">
    <div class="nav-links">
        <!-- <a href="public.php?page=userDashboard">Home</a> -->
      <a href="/MVC-project/MVC_project/public.php?page=userDashboard">Home</a>
       <a href="public.php?page=userDashboard#about">About Us</a>
        <a href="public.php?page=cart" id="num">🛒 <span id="cartCount"><?= intval($cartCount) ?></span></a>
        <a href="public.php?page=like" id="num">❤️ <span id="likeCount"><?= intval($likeCount) ?></span></a>
        <a href="public.php?page=logout">🚪 Logout</a>
    </div>
    <div class="user">
        <?= isset($_SESSION['username']) ? "👋 Welcome, " . htmlspecialchars($_SESSION['username']) : "Not logged in" ?>
    </div>
</nav>

