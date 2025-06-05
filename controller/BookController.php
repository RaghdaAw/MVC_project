<?php
include "../model/dbConnect.php";
include '../model/Book.php';

class BookController
{
    private $bookModel;

    public function __construct($pdo)
    {
        $this->bookModel = new Book($pdo);
    }

    public function getBookById($id)
    {
        return $this->bookModel->getBookById($id);
    }

    public function addBook()
    {
        if (isset($_POST['submit'])) {
            $image_url = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $dir = "../view/uploadImages/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $dir . $unique_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = $target_file;
                }
            }

            $this->bookModel->insertBook(
                $_POST['name'],
                $_POST['author'],
                $_POST['year'],
                $_POST['price'],
                $_POST['description'],
                $image_url
            );

            header("Location: ../view/index.php");
            exit;
        }
    }

    public function deleteBook()
    {
        if (isset($_GET['del'])) {
            $id = intval($_GET['del']);
            $this->bookModel->deleteBook($id);
            header("Location: ../view/index.php");
            exit;
        }
    }

    public function updateBook()
    {
        echo "Updating book...";
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $image_url = $_POST['old_image'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $dir = "../view/uploadImages/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }

                $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
                $target_file = $dir . $unique_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = $target_file;
                }
            }

            $this->bookModel->updateBook(
                $id,
                $_POST['name'],
                $_POST['author'],
                $_POST['year'],
                $_POST['price'],
                $_POST['description'],
                $image_url
            );

            header("Location: ../view/index.php");
            exit;
        }
    }
}

// تنفيذ العمليات حسب الطلب:
$controller = new BookController($pdo);

if (isset($_POST['submit'])) {
    $controller->addBook();
}

if (isset($_GET['del'])) {
    $controller->deleteBook();
}

if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $book = $controller->getBookById($id);

    if ($book) {
        include '../view/editBook.php';
    } else {
        echo "❌ Book not found.";
    }
}
if (isset($_POST['update'])) {
    $controller->updateBook();
}
