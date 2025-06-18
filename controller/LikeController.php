<?php
require_once __DIR__ . '/../model/LikeModel.php';
// include_once __DIR__ . '/../view/book/BookView.php';


class LikeController
{
    public static function likeBook()
    {
        session_start();

        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "⛔ You must be logged in and select a book.";
            return;
        }

        $user_id = $_SESSION['user_id'];
        $product_id = $_GET['id'];

        $success = LikeModel::likeProduct($user_id, $product_id);

        if ($success) {
            header("Location: public.php?page=books");
            exit;
        } else {
            echo "❤️ You already liked this book.";
        }
    }
}
