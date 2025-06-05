<?php
include '../controller/BookController.php';
include '../controller/UserController.php';

$myBooks = new Book($pdo);
$books = $myBooks->getAllBooks();

?>
<h1>Book Details</h1>
<?php foreach ($books as $row): ?>
    <div class="book-item">
        <p><strong>ID:</strong> <?= $row['product_id']; ?></p>
        <p><strong>Name:</strong> <?= $row['name']; ?></p>
        <p><strong>Author:</strong> <?= $row['author']; ?></p>
        <p><strong>Year:</strong> <?= $row['year']; ?></p>
        <p><strong>Price:</strong> <?= $row['price']; ?></p>
        <p><strong>Description:</strong> <?= $row['description']; ?></p>

        <?php if (!empty($row['image_url'])): ?>
            <p><img src="<?= $row['image_url']; ?>" alt="Book Image" style="width:100px;height:auto;"></p>
        <?php endif; ?>




    </div>
<?php endforeach; ?>
<?php
$bookController = new BookController($pdo);

$page = $_GET['page'] ?? 'books';

//         if ($page === 'books') {
//     $bookController->showAllBooks();
// }
// ?>