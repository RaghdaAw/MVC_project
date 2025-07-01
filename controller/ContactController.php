<?php
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../model/LikeModel.php';
require_once __DIR__ . '/../view/contact.php';

class ContactController
{
    public static function show()
    {

        $cartCount = 0;
        $likeCount = 0;
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $cartCount = CartModel::getCartItemCount($user_id);
            $likeCount = LikeModel::getLikeCount($user_id);
        }

        ContactView::renderContactPage($cartCount, $likeCount);
    }
}
