<?php
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../model/LikeModel.php';

class NavbarHelper {
    public static function getNavbarData() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? null;
        $username = $_SESSION['username'] ?? null;

        $cartCount = $userId ? CartModel::getCartItemCount($userId) : 0;
        $likeCount = $userId ? LikeModel::getLikeCount($userId) : 0;

        return [
            'username' => $username,
            'cartCount' => $cartCount,
            'likeCount' => $likeCount,
        ];
    }
}
