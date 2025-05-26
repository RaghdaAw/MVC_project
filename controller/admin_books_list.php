<?php
include("../model/dbConnect.php");
include("../model/Book.php");
$book = new Book($pdo);
$books = $book->getAllBooks();
?>


