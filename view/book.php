

<?php foreach ($books as $book): ?>
  <article class="col-6 col-12-xsmall work-item">
    <img src="<?= $book['image'] ?>" alt="<?= htmlspecialchars($book['title']) ?>" />
    <i class="fa-solid fa-heart"></i>
    <i class="fa-solid fa-cart-plus"></i>
    <h3><?= htmlspecialchars($book['title']) ?></h3>
    <p><?= htmlspecialchars($book['description']) ?></p>
    <p><?= number_format($book['price'], 2) ?> €</p>
  </article>
<?php endforeach; ?>

<!-- voor admin_books_list.php -->
<?php foreach ($books as $row): ?>
    <div>
        <p><?= $row['name']; ?> - <?= $row['author']; ?></p>
        <img src="<?= $row['image_url']; ?>" width="100">
        <a href="admin_delete_book.php?del=<?= $row['product_id']; ?>"
           onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</a>
    </div>
<?php endforeach; ?>