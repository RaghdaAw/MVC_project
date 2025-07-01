<?php

include_once __DIR__ . '/../model/Book.php';
include_once __DIR__ . '/../view/book/BookView.php';
include_once __DIR__ . '/../model/LikeModel.php';
include_once __DIR__ . '/../model/CartModel.php';

class BookController
{
    private static $uploadDir;

    public static function init()
    {
        // Upload folder - absolute path
        self::$uploadDir = realpath(__DIR__ . '/../views/uploadImages') . DIRECTORY_SEPARATOR;
        if (!file_exists(self::$uploadDir)) {
            mkdir(self::$uploadDir, 0755, true);
        }
    }

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
                // Check allowed file types (jpg, png, gif)
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowed)) {
                    echo "❌ Unsupported file type.";
                    return;
                }

                $uniqueName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFile = self::$uploadDir . $uniqueName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    // Use relative path for the project
                    $image_url = 'views/uploadImages/' . $uniqueName;
                } else {
                    echo "❌ Error uploading file.";
                    return;
                }
            }

            $book = new Book();
            $book->name = $_POST['name'] ?? '';
            $book->author = $_POST['author'] ?? '';
            $book->year = $_POST['year'] ?? '';
            $book->price = $_POST['price'] ?? '';
            $book->description = $_POST['description'] ?? '';
            $book->image_url = $image_url;

            $book->save();

            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function delete()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $book = Book::findByID($_GET['id']);
            if ($book) {
                $book->delete();
            }
            header("Location: public.php?page=books");
            exit;
        } else {
            echo "⛔ Invalid book ID.";
        }
    }

    public static function edit()
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "⛔ Book ID is missing or invalid.";
            return;
        }

        $book = Book::findByID($_GET['id']);

        if (!$book) {
            echo "⛔ Book not found.";
            return;
        }

        BookView::renderEditForm($book);
    }

    public static function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                echo "⛔ The book ID is invalid.";
                return;
            }

            $book = Book::findByID($_POST['id']);
            if (!$book) {
                echo "⛔ Book not found.";
                return;
            }

            $image_url = $_POST['old_image'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($_FILES['image']['type'], $allowed)) {
                    echo "❌ File type not allowed.";
                    return;
                }
                // Delete the old image if it exists
                if (!empty($image_url)) {
                    $oldImageFullPath = realpath(__DIR__ . '/../' . $image_url);
                    if ($oldImageFullPath && file_exists($oldImageFullPath)) {
                        unlink($oldImageFullPath);
                    }
                }

                $uniqueName = time() . "_" . basename($_FILES["image"]["name"]);
                $targetFile = self::$uploadDir . $uniqueName;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $image_url = 'views/uploadImages/' . $uniqueName;
                } else {
                    echo "❌ Error uploading file.";
                    return;
                }
            }

            $book->name = $_POST['name'] ?? '';
            $book->author = $_POST['author'] ?? '';
            $book->year = $_POST['year'] ?? '';
            $book->price = $_POST['price'] ?? '';
            $book->description = $_POST['description'] ?? '';
            $book->image_url = $image_url;

            $book->save();

            header("Location: public.php?page=books");
            exit;
        }
    }

    public static function showUserBooks()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $books = Book::getAll();
        global $pdo;
        $likeCount = 0;
        $cartCount = 0;


        if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
            $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
            $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
        }

        BookView::renderUserBookList($books, $cartCount, $likeCount);
    }

    public static function search(): void
    {
        $likeCount = 0;
        $cartCount = 0;
        if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
            echo "❌ Please enter a search term.";
            return;
        }

        $keyword = htmlspecialchars(trim($_GET['q']));
        $books = Book::search($keyword);
        $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
        $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);

        if (empty($books)) {
            echo "❌ No results found for: " . htmlspecialchars($keyword);
            return;
        }

        BookView::renderSearchResults($books, $keyword, $cartCount, $likeCount);
    }
}

BookController::init();
