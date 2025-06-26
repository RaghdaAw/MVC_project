<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../model/LikeModel.php';

$userId = $_SESSION['user_id'] ?? null;
$cartCount = $userId ? CartModel::getCartItemCount($userId) : 0;
$likeCount = $userId ? LikeModel::getLikeCount($userId) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/css/main.css" />
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="contact-container">
        <h2>Contact Us</h2>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="success-msg">✅ Thank you, your message has been sent.</p>
        <?php endif; ?>
    </div>

</body>
</html>
