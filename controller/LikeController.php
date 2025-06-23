<?php
require_once __DIR__ . '/../model/LikeModel.php';
require_once __DIR__ . '/../view/like/LikeView.php';

class LikeController
{
    private static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Handle user liking a book
    public static function likeBook()
    {
        self::startSession();

        if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
            echo "⛔ You must be logged in and select a book.";
            return;
        }

        $user_id    = (int) $_SESSION['user_id'];
        $product_id = (int) $_GET['id'];

        $like = new LikeModel();
        $like->user_id    = $user_id;
        $like->product_id = $product_id;

        $success = $like->save();

        if ($success) {
            header("Location: public.php?page=books");
            exit;
        } else {
            echo "❤️ You already liked this book.";
        }
    }

    // Show liked books by user
    public static function showLike()
    {
        self::startSession();

        if (!isset($_SESSION['user_id'])) {
            echo "❌ Please log in to view your Likes.";
            return;
        }

        $user_id = (int) $_SESSION['user_id'];
        $items = LikeModel::getLikeItemsByUser($user_id);

        LikeView::renderUserLikeList($items);
    }

    // Delete a like by ID
    public static function delete()
    {
        self::startSession();

        if (!isset($_GET['idlike']) || !isset($_SESSION['user_id'])) {
            echo "❌ Invalid request.";
            return;
        }

        $like_id = (int) $_GET['idlike'];
        $user_id = (int) $_SESSION['user_id'];

        $success = LikeModel::removeFromLike($user_id, $like_id);

        if ($success) {
            header("Location: public.php?page=like");
            exit;
        } else {
            echo "❌ Failed to remove like.";
        }
    }
}
