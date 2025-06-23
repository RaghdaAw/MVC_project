<?php
require_once __DIR__ . '/../model/LikeModel.php';
require_once __DIR__ . '/../view/like/LikeView.php';

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
        $product_id = (int) $_GET['id'];

        $like = new LikeModel();
        $like->user_id = $user_id;
        $like->product_id = $product_id;

        $success = $like->save();

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
            echo "❌ Please log in to view your Likes.";
            return;
        }

        $user_id = $_SESSION['user_id'];
        $items = LikeModel::getLikeItemsByUser($user_id);

        LikeView::renderUserLikeList($items);
    }

    public static function delete()
    {
        session_start(); // تأكد من تفعيل الجلسة

        if (!isset($_GET['idlike']) || !isset($_SESSION['user_id'])) {
            echo "❌ Invalid request.";
            return;
        }

        $like_id = (int) $_GET['idlike'];
        $user_id = $_SESSION['user_id'];

        $success = LikeModel::removeFromLike($user_id, $like_id);

        if ($success) {
            header("Location: public.php?page=like");
            exit;
        } else {
            echo "❌ Failed to remove like.";
        }
    }
}
