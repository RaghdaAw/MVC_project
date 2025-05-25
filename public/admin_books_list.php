<?php
include("../model/dbConnect.php");
include("../model/Book.php");
$book = new Book($pdo);
$books = $book->getAllBooks();
?>

<?php foreach ($books as $row): ?>
    <div>
        <p><?= $row['name']; ?> - <?= $row['author']; ?></p>
        <img src="<?= $row['image_url']; ?>" width="100">
        <a href="admin_delete_book.php?del=<?= $row['product_id']; ?>"
           onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</a>
    </div>
<?php endforeach; ?>
