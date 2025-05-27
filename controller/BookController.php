<?php
include_once '../model/Book.php';

class BookController
{
    private $bookModel;

    public function __construct($pdo)
    {
        $this->bookModel = new Book($pdo);
    }

    public function showAllBooks()
    {
        $books = $this->bookModel->getAllBooks();
        include '../view/book_list.php'; // الملف الذي يحتوي على HTML
    }
}
