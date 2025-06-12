<?php

class BookView
{
    public static function renderBookList($books)
    {
        echo "<h2>📚 All Books</h2><a href='public.php?page=addBook'>➕ Add Book</a><br><br>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Image</th><th>Name</th><th>Author</th><th>Year</th><th>Price</th><th>Description</th><th>Action</th></tr>";

        foreach ($books as $book) {
            $img = $book['image_url'] ? "<img src='{$book['image_url']}' width='100'>" : "No image";
            echo "<tr>
                <td>{$img}</td>
                <td>{$book['name']}</td>
                <td>{$book['author']}</td>
                <td>{$book['year']}</td>
                <td>{$book['price']}</td>
                <td>{$book['description']}</td>
                <td><a href='public.php?page=editBook&id={$book['product_id']}'>✏️ Edit</a></td>
                <td><a href='public.php?page=deleteBook&id={$book['product_id']}' onclick='return confirm(\"Are you sure?\")'>🗑 Delete</a></td>
                

            </tr>";
        }

        echo "</table>";
    }

    public static function renderAddForm()
{
    echo "<h2>➕ add Book </h2>";
    ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>📖Name Book:</label><br>
        <input type="text" name="name" required><br><br>

        <label>✍️ Author:</label><br>
        <input type="text" name="author" required><br><br>

        <label>📅 Year:</label><br>
        <input type="number" name="year" required><br><br>

        <label>💰 Price:</label><br>
        <input type="number" name="price" required><br><br>

        <label>📝 Description:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>🖼️ Image:</label><br>
        <input type="file" name="image"><br><br>

        <input type="submit" name="submit" value="➕ Add Book">
    </form>
    <?php
}

public static function renderEditForm($book)
{
    ?>
    <h2>✏️ Edit Book</h2>
    <form method="POST" action="public.php?page=updateBook&id=<?= $book['product_id']; ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $book['product_id'] ?>">
        <input type="hidden" name="old_image" value="<?= $book['image_url'] ?>">

        <label>Book name</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($book['name']) ?>" required><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br><br>

        <label>Year:</label><br>
        <input type="number" name="year" value="<?= htmlspecialchars($book['year']) ?>" required><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($book['price']) ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" required><?= htmlspecialchars($book['description']) ?></textarea><br><br>

        <label>Old Image:</label><br>
        <?php if (!empty($book['image_url'])): ?>
            <img src="<?= $book['image_url'] ?>" width="150"><br>
        <?php else: ?>
            <span>No Image</span><br>
        <?php endif; ?>

        <label>New Image:</label><br>
        <input type="file" name="image"><br><br>

        <button type="submit" name="update">Update</button>
    </form>
    <?php
}

public static function renderUserBookList($books)
    {
        echo "<h1>📘 Book Details</h1>";

        foreach ($books as $row) {
            echo "<div class='book-item' style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
            echo "<p><strong>ID:</strong> {$row['product_id']}</p>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
            echo "<p><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>";
            echo "<p><strong>Year:</strong> {$row['year']}</p>";
            echo "<p><strong>Price:</strong> {$row['price']}</p>";
            echo "<p><strong>Description:</strong> " . nl2br(htmlspecialchars($row['description'])) . "</p>";

            if (!empty($row['image_url'])) {
                echo "<p><img src='{$row['image_url']}' alt='Book Image' style='width:100px;height:auto;'></p>";
            }

            echo "<a href='?page=addToFavorite&id={$row['product_id']}'>➕ Add to Favorites</a> | ";
            echo "<a href='?page=likeBook&id={$row['product_id']}' onclick='return confirm(\"Are you sure?\")'>❤️ Like</a>";
            echo "</div>";
        }
    }

}

