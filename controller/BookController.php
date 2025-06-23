<?php

include_once __DIR__ . '/../model/Book.php';
include_once __DIR__ . '/../view/book/BookView.php';
include_once __DIR__ . '/../model/LikeModel.php';
include_once __DIR__ . '/../model/CartModel.php';

class BookController
{
    public static function showAll()
    {
        $books = Book::getAll();
        BookView::renderBookList($books);
    }

    public static function add()
    {
        BookView::renderAddForm();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $image_url = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = __DIR__ . '/../views/uploadImages/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uniqueName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFile = $uploadDir . $uniqueName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $image_url = 'views/uploadImages/' . $uniqueName;
                }
            }

            $book = new Book();
            $book->name = $_POST['name'];
            $book->author = $_POST['author'];
            $book->year = $_POST['year'];
            $book->price = $_POST['price'];
            $book->description = $_POST['description'];
            $book->image_url = $image_url;

            $book->save();

            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function delete()
    {
        if (isset($_GET['id'])) {
            $book = Book::load($_GET['id']);
            if ($book) {
                $book->delete();
            }
            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function edit()
    {
        if (!isset($_GET['id'])) {
            echo "⛔ Book ID is missing.";
            return;
        }

        $book = Book::load($_GET['id']);

        if (!$book) {
            echo "⛔ Book not found.";
            return;
        }

        BookView::renderEditForm($book);
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $book = Book::load($_POST['id']);
            if (!$book) {
                echo "⛔ Book not found.";
                return;
            }

            $image_url = $_POST['old_image'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = __DIR__ . '/../views/uploadImages/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!empty($image_url) && file_exists($image_url)) {
                    unlink($image_url);
                }

                $uniqueName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFile = $uploadDir . $uniqueName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $image_url = 'views/uploadImages/' . $uniqueName;
                }
            }

            $book->name = $_POST['name'];
            $book->author = $_POST['author'];
            $book->year = $_POST['year'];
            $book->price = $_POST['price'];
            $book->description = $_POST['description'];
            $book->image_url = $image_url;

            $book->save();

            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function showUserBooks()
    {
        $books = Book::getAll();

        LikeModel::setConnection($GLOBALS['pdo']);
        CartModel::setConnection($GLOBALS['pdo']);

        $likeCount = 0;
        $cartCount = 0;

        if (isset($_SESSION['user_id'])) {
            $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
            $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
        }

        BookView::renderUserBookList($books, $cartCount, $likeCount);
    }

    public static function search()
    {
        if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
            echo "❌ Vul een zoekterm in.";
            return;
        }

        $keyword = htmlspecialchars($_GET['q']);
        $books = Book::search($keyword);

        BookView::renderSearchResults($books, $keyword);
    }
}
