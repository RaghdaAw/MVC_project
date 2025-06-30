<?php
include_once __DIR__ . '/../model/CartModel.php';
include_once __DIR__ . '/../view/cart/CartView.php';

class CartController
{
    public static function execute()
    {
        if (!isset($_SESSION['user_id'])) {
            echo "⛔ You must be logged in to view your cart.";
            return;
        }

        $userId =(int) $_SESSION['user_id'];
        $items = CartModel::getCartItemsByUser($userId);
        $cartCount = CartModel::getCartItemCount($userId);
        $likeCount = LikeModel::getLikeCount($userId);


        CartView::renderUserCartList($items, $cartCount, $likeCount);
    }

    public static function addToCart()
    {
        if (!isset($_SESSION['user_id'], $_GET['id'])) {
            echo "⛔ Missing data";
            return;
        }

        $cartItem = new CartModel();
        $cartItem->user_id = $_SESSION['user_id'];
        $cartItem->product_id = $_GET['id'];
        $cartItem->save();

        header("Location: public.php?page=userDashboard");
        exit;
    }

    public static function delete()
    {
        if (!isset($_GET['cart_id'])) {
            echo "⛔ Invalid ID";
            return;
        }

        $cart_id = $_GET['cart_id'];
        $item = CartModel::findByID($cart_id);

        if ($item !== null) {
            try {
                $item->delete();
            } catch (Exception $e) {
                echo "❌ Failed to delete item: " . $e->getMessage();
                return;
            }
        } else {
            echo "⚠️ Cart item not found.";
            return;
        }

        header("Location: public.php?page=cart");
        exit;
    }
}
