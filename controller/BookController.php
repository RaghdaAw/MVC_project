<?php
include_once '../model/Book.php';

class BookController
{
    private $bookModel;

    public function __construct($pdo)
    {
        $this->bookModel = new Book($pdo);
    }
    public function addBook()
    {
        if (isset($_POST['submit'])) {
            $image_url = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $dir = "../view/uploadImages/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true); // إنشاء المجلد إذا لم يكن موجودًا
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
             echo "✅ add the book!";
             
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
    // public function showAllBooks()
    // {
    //     $books = $this->bookModel->getAllBooks();
    //     include '../view/index.php'; // الملف الذي يحتوي على HTML
    // }
}
 if (isset($_POST['submit'])) {
        require_once '../model/dbConnect.php';
        $controller = new BookController($pdo);
        $controller->addBook();
    }

if (isset($_GET['del'])) {
    require_once '../model/dbConnect.php';
    $controller = new BookController($pdo);
    $controller->deleteBook();
}