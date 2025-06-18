<?php
require_once __DIR__ . '/../model/LikeModel.php';
include_once __DIR__ . '/../view/like/LikeView.php';


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

    public static function showLike()
    {
        // session_start();
        if (!isset($_SESSION['user_id'])) {
            echo "❌ Please log in to view your Like.";
            return;
        }

        $user_id = $_SESSION['user_id'];
        $items = LikeModel::getLikeItems($user_id);
        LikeView::renderUserLikeList($items);
    }

    public static function delete()
{
    if (!isset($_GET['idlike']) || !isset($_SESSION['user_id'])) {
        echo "❌ Invalid request.";
        return;
    }

    $like_id = $_GET['idlike'];
    $user_id = $_SESSION['user_id'];

    $success = LikeModel::removeFromLike($user_id, $like_id);

    if ($success) {
        header("Location: public.php?page=like");
        exit;
    } else {
        echo "❌ Failed to remove item.";
    }
}

}
