<?php
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../view/cart/CartView.php';

class CartController
{
   
    public static function addToCart()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "⛔ User not logged in or no book selected";
            return;
        }

        $userId = $_SESSION['user_id'];
        $productId = $_GET['id'];

        $success = CartModel::addToCart($userId, $productId);

        if ($success) {
            header("Location: public.php?page=userDashboard");
            exit;
        } else {
            echo "❌ Failed to add book to cart";
        }
    }

    public static function showCart()
    {
        // session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "❌ Please log in to view your cart.";
            return;
        }

        $user_id = $_SESSION['user_id'];
        $items = CartModel::getCartItems($user_id);
        CartView::renderUserCartList($items);
    }

  public static function delete()
{
    if (!isset($_GET['idcart']) || !isset($_SESSION['user_id'])) {
        echo "❌ Invalid request.";
        return;
    }

    $cart_id = $_GET['idcart'];
    $user_id = $_SESSION['user_id'];

    $success = CartModel::removeFromCart($user_id, $cart_id);

    if ($success) {
        header("Location: public.php?page=cart");
        exit;
    } else {
        echo "❌ Failed to remove item.";
    }
}


}
