<?php
include("../model/dbConnect.php");
include("../model/Book.php");

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $book = new Book($pdo);
    $book->deleteBook($id);
}

header("Location:index.php");
exit;
