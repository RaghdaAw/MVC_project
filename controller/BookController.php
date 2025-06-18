<?php

include_once __DIR__ . '/../model/Book.php';
include_once __DIR__ . '/../view/book/BookView.php';
include_once __DIR__ . '/../model/LikeModel.php';

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

            // Insert the book into the database
            $bookModel->insertBook(
                $_POST['name'],
                $_POST['author'],
                $_POST['year'],
                $_POST['price'],
                $_POST['description'],
                $image_url
            );
            // Redirect to the book list page
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

            $product_id = $_POST['id'];
            $name = $_POST['name'];
            $author = $_POST['author'];
            $year = $_POST['year'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $old_image = $_POST['old_image'];
            $image_url = $old_image;

            // new image upload logic
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $dir = __DIR__ . '/../views/uploadImages/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                // delete old image if exists
                if (!empty($old_image) && file_exists($old_image)) {
                    unlink($old_image);
                }

                $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $dir . $unique_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = 'views/uploadImages/' . $unique_name;
                }
            }

            // Update the book in the database 
            $bookModel->updateBook($product_id, $name, $author, $year, $price, $description, $image_url);

            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function showUserBooks()
    {
        // session_start();

        $bookModel = new Book($GLOBALS['pdo']);
        $books = $bookModel->getAllBooks();
        LikeModel::setConnection($GLOBALS['pdo']);
        CartModel::setConnection($GLOBALS['pdo']);

        BookView::renderUserBookList($books);


        $likeCount = 0;
        $cartCount = 0;

        if (isset($_SESSION['user_id'])) {
            $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
            $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
        }

        // تمرير البيانات إلى الـ View
        BookView::renderUserBookList($books, $cartCount, $likeCount);
    }


}


