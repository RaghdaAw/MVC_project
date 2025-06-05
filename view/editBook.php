<?php
// تأكد من وجود بيانات الكتاب مثلاً عبر: $book = $this->bookModel->getBookById($id);
// لنفترض أن المتغير $book يحتوي على بيانات الكتاب
// include '../controller/BookController.php';
?>

<h2> edit book</h2>

<form method="POST" action="../controller/BookController.php?update=<?= $book['product_id']; ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $book['product_id'] ?>">
    <input type="hidden" name="old_image" value="<?= $book['image_url'] ?>">

    <label>Book name</label><br>
    <input type="text" name="name" value="<?= htmlspecialchars($book['name']) ?>" required><br><br>

    <label>Author:</label><br>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br><br>

    <label>year:</label><br>
    <input type="number" name="year" value="<?= htmlspecialchars($book['year']) ?>" required><br><br>

    <label>Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($book['price']) ?>" required><br><br>

    <label> Description:</label><br>
    <textarea name="description" required><?= htmlspecialchars($book['description']) ?></textarea><br><br>

    <label> old image:</label><br>
    <?php if (!empty($book['image_url'])): ?>
        <img src="<?= $book['image_url'] ?>" width="150"><br>
    <?php else: ?>
        <span> No Image  </span><br>
    <?php endif; ?>
    <label>  other image:</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit" name="update">Update</button>

</form>
