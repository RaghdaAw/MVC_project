<!-- 
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="../styles.css"> -->

<?php

class BookView
{
    public static function renderBookList($books)
    {
        if (isset($_SESSION['username'])) {
            echo "<div class='name'>Welkom, " . $_SESSION['username'] . "</div>";
            echo '<a href="public.php?page=logout">🚪 Logout</a>';
        } else {
            echo "<div class='name'>Login</div>";
        }
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

    public static function renderUserBookList($books, $cartCount = 0, $likeCount = 0)
    {
        if (isset($_SESSION['username'])) {
            echo "<div class='name'>Welkom, " . $_SESSION['username'] . "</div>";
            echo '<a href="public.php?page=logout">🚪 Logout</a>';
        } else {
            echo "<div class='name'>Login</div>";
        }

        if (isset($_SESSION['user_id'])) {
            $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
            $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
        }

        echo '<a href="public.php?page=cart" id="num">🛒 <span id="cartCount">' . $cartCount . '</span></a>';
        echo ' <a href="public.php?page=like" id="num">❤️ <span id="likeCount">' . $likeCount . '</span>';

        echo '<section id="two">';
        echo '<h2>📘 Book Details</h2>';
        echo '<div class="row">';

        foreach ($books as $row) {
            $img = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'images/thumbs/default.jpg';
            $name = htmlspecialchars($row['name']);
            $author = htmlspecialchars($row['author']);
            $desc = nl2br(htmlspecialchars($row['description']));
            $price = htmlspecialchars($row['price']);
            $id = $row['product_id'];

            echo '
        <article class="col-6 col-12-xsmall work-item" style="border:1px solid #ccc; padding:10px;">
            <a href="' . $img . '" class="image fit thumb">
                <img src="' . $img . '" alt="' . $name . '" />
            </a>

            <h3>' . $name . '</h3>
            <p><strong>Author:</strong> ' . $author . '</p>
            <p>' . $desc . '</p>
            <p><strong>Price:</strong> ' . $price . ' €</p>

            <div style="margin-top:10px;">
                <button class="add-to-cart" data-id="' . $id . '" style="background:#2ecc71; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer;">
                    ➕ Add to Cart
                </button>
                <button class="like-button" data-id="' . $id . '"
                 style="background:#e74c3c; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">
                 ❤️ Like
                 </button>

            </div>
        </article>';
        }

        echo '</div>';
        echo '</section>';
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll('.add-to-cart').forEach(button => {
                    button.addEventListener('click', function () {
                        const productId = this.dataset.id;

                        fetch('ajax/addToCart.php?id=' + productId)
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById('cartCount').innerText = data.count;
                                } else {
                                    alert('❌ Failed to add to cart');
                                }
                            });
                    });
                });
            });

            // Like button functionality
            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.dataset.id;

                    fetch('ajax/likeBook.php?id=' + productId)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('likeCount').innerText = data.count;
                            } else {
                                alert('❌ Failed to like the book');
                            }
                        });
                });
            });

        </script>
        <?php
    }

public static function renderSearchResults($books, $keyword)
{
        
        if (isset($_SESSION['user_id'])) {
            $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
            $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
        }

        echo '<a href="public.php?page=cart" id="num">🛒 <span id="cartCount">' . $cartCount . '</span></a>';
        echo ' <a href="public.php?page=like" id="num">❤️ <span id="likeCount">' . $likeCount . '</span>';

        echo '<section id="two">';
        echo '<h2>🔍 Search results</h2>';
        echo '<div class="row">';

        foreach ($books as $row) {
            $img = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'images/thumbs/default.jpg';
            $name = htmlspecialchars($row['name']);
            $author = htmlspecialchars($row['author']);
            $desc = nl2br(htmlspecialchars($row['description']));
            $price = htmlspecialchars($row['price']);
            $id = $row['product_id'];

            echo '
        <article class="col-6 col-12-xsmall work-item" style="border:1px solid #ccc; padding:10px;">
            <a href="' . $img . '" class="image fit thumb">
                <img src="' . $img . '" alt="' . $name . '" />
            </a>

            <h3>' . $name . '</h3>
            <p><strong>Author:</strong> ' . $author . '</p>
            <p>' . $desc . '</p>
            <p><strong>Price:</strong> ' . $price . ' €</p>

            <div style="margin-top:10px;">
                <button class="add-to-cart" data-id="' . $id . '" style="background:#2ecc71; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer;">
                    ➕ Add to Cart
                </button>
                <button class="like-button" data-id="' . $id . '"
                 style="background:#e74c3c; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">
                 ❤️ Like
                 </button>

            </div>
        </article>';
        
    }

}
}

