<?php

include_once __DIR__ . '/../model/Book.php';
include_once __DIR__ . '/../model/entities/BookData.php';
include_once __DIR__ . '/../view/book/BookView.php';
include_once __DIR__ . '/../model/LikeModel.php';
include_once __DIR__ . '/../model/CartModel.php';

class BookController
{
    public static function showAll()
    {
        $bookModel = new Book($GLOBALS['pdo']);
        $books = $bookModel->getAllBooks();
        BookView::renderBookList($books);
    }

    public static function add()
    {
        BookView::renderAddForm();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $bookModel = new Book($GLOBALS['pdo']);
            $image_url = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $dir = __DIR__ . '/../views/uploadImages/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $dir . $unique_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = 'views/uploadImages/' . $unique_name;
                }
            }

            $bookData = new BookData(
                null,
                $_POST['name'],
                $_POST['author'],
                $_POST['year'],
                $_POST['price'],
                $_POST['description'],
                $image_url
            );

            $bookModel->insertBook($bookData);
            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function delete()
    {
        if (isset($_GET['id'])) {
            $bookModel = new Book($GLOBALS['pdo']);
            $bookModel->deleteBook($_GET['id']);
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

        $bookModel = new Book($GLOBALS['pdo']);
        $book = $bookModel->getBookById($_GET['id']);

        if (!$book) {
            echo "⛔ Book not found.";
            return;
        }

        BookView::renderEditForm($book);
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $bookModel = new Book($GLOBALS['pdo']);

            $image_url = $_POST['old_image'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $dir = __DIR__ . '/../views/uploadImages/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                if (!empty($image_url) && file_exists($image_url)) {
                    unlink($image_url);
                }

                $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $dir . $unique_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = 'views/uploadImages/' . $unique_name;
                }
            }

            $bookData = new BookData(
                $_POST['id'],
                $_POST['name'],
                $_POST['author'],
                $_POST['year'],
                $_POST['price'],
                $_POST['description'],
                $image_url
            );

            $bookModel->updateBook($bookData);

            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function showUserBooks()
    {
        $bookModel = new Book($GLOBALS['pdo']);
        $books = $bookModel->getAllBooks();

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

        $bookModel = new Book($GLOBALS['pdo']);
        $books = $bookModel->searchBooks($keyword);

        BookView::renderSearchResults($books, $keyword);
    }
}
