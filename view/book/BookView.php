<?php

  class BookView
{
    public static function renderBookList($books)
{
    include __DIR__ . '/../navbarAdmin.php';
    ?>
   

        <h2>📚 All Books</h2>
        <!-- <a href='public.php?page=addBook' class="add-book-button">➕ Add Book</a> -->

        <div class="book-cards">
            <?php foreach ($books as $book): ?>
                <div class="book-card">
                    <?php if ($book->image_url): ?>
                        <img src="<?= htmlspecialchars($book->image_url) ?>" alt="Book Cover">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>

                    <div class="book-info">
                        <h3><?= htmlspecialchars($book->name) ?></h3>
                        <p><strong>Author:</strong> <?= htmlspecialchars($book->author) ?></p>
                        <p><strong>Year:</strong> <?= htmlspecialchars($book->year) ?></p>
                        <p><strong>Price:</strong> €<?= htmlspecialchars($book->price) ?></p>
                        <p><?= htmlspecialchars($book->description) ?></p>
                        <div class="book-actions">
                            <a href="public.php?page=editBook&id=<?= urlencode($book->getID()) ?>" class="edit-btn">✏️ Edit</a>
                            <a href="public.php?page=deleteBook&id=<?= urlencode($book->getID()) ?>" class="delete-btn" onclick="return confirm('Are you sure?')">🗑 Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}


    public static function renderAddForm()
    {
    include __DIR__ . '/../navbarAdmin.php';

        echo '<h2 class="page-title">✏️ Add Book</h2>';

        ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <label>📖Name Book:</label><br>
            <input type="text" name="name" required><br><br>

            <label>✍️ Author:</label><br>
            <input type="text" name="author" required><br><br>

            <label>📅 Year:</label><br>
            <input type="number" name="year" required><br><br>

            <label>💰 Price:</label><br>
            <input type="number" step="0.01" name="price" required><br><br>

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
    include __DIR__ . '/../navbarAdmin.php';

        ?>
        <h2>✏️ Edit Book</h2>
        <form method="POST" action="public.php?page=updateBook&id=<?= urlencode($book->getID()); ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($book->getID()) ?>">
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($book->image_url) ?>">

            <label>Book name</label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($book->name) ?>" required><br><br>

            <label>Author:</label><br>
            <input type="text" name="author" value="<?= htmlspecialchars($book->author) ?>" required><br><br>

            <label>Year:</label><br>
            <input type="number" name="year" value="<?= htmlspecialchars($book->year) ?>" required><br><br>

            <label>Price:</label><br>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($book->price) ?>" required><br><br>

            <label>Description:</label><br>
            <textarea name="description" required><?= htmlspecialchars($book->description) ?></textarea><br><br>

            <label>Old Image:</label><br>
            <?php if (!empty($book->image_url)): ?>
                <img src="<?= htmlspecialchars($book->image_url) ?>" width="150"><br>
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
        include __DIR__ . '/../navbar.php';

        // if (isset($_SESSION['username'])) {
        //     echo "<div class='name'>Welkom, " . htmlspecialchars($_SESSION['username']) . "</div>";
        //     echo '<a href="public.php?page=logout">🚪 Logout</a>';
        // } else {
        //     echo "<div class='name'>Login</div>";
        // }

        // if (isset($_SESSION['user_id'])) {
        //     $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
        //     $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
        // }

        // echo '<a href="public.php?page=cart" id="num">🛒 <span id="cartCount">' . intval($cartCount) . '</span></a>';
        // echo ' <a href="public.php?page=like" id="num">❤️ <span id="likeCount">' . intval($likeCount) . '</span></a>';

        echo '<section id="two">';
        echo '<h2>📘 Book Details</h2>';
        echo '<div class="row">';

        foreach ($books as $book) {
            $img = !empty($book->image_url) ? htmlspecialchars($book->image_url) : 'images/thumbs/default.jpg';
            $name = htmlspecialchars($book->name);
            $author = htmlspecialchars($book->author);
            $desc = nl2br(htmlspecialchars($book->description));
            $price = htmlspecialchars($book->price);
            $id_product= $book->getID();

            echo '
            <article class="col-6 col-12-xsmall work-item" >
            
                <a href="' . $img . '" class="image fit thumb">
                    <img src="' . $img . '" alt="' . $name . '" />
                </a>

                <h3>' . $name . '</h3>
                <p><strong>Author:</strong> ' . $author . '</p>
                <p>' . $desc . '</p>
                <p><strong>Price:</strong> ' . $price . ' €</p>

                <div style="margin-top:10px;">
                    <button class="add-to-cart" data-id="' . htmlspecialchars($id_product) . '">
                        ➕ Add to Cart
                    </button>
                    <button class="like-button" data-id="' . htmlspecialchars($id_product) . '">
                     ❤️ Like
                     </button>
                </div>
            </article>';
        }

        echo '</div>';
        echo '</section>';
        ?>
        <section id="about">
            <?php
            include __DIR__ . '/../about.php';
            ?>
        </section>
            <?php

        include __DIR__ . '/../footer.php';

    }

    public static function renderSearchResults($books, $keyword)
    {
        if (isset($_SESSION['user_id'])) {
            $cartCount = CartModel::getCartItemCount($_SESSION['user_id']);
            $likeCount = LikeModel::getLikeCount($_SESSION['user_id']);
        } else {
            $cartCount = 0;
            $likeCount = 0;
        }

        echo '<a href="public.php?page=cart" id="num">🛒 <span id="cartCount">' . intval($cartCount) . '</span></a>';
        echo ' <a href="public.php?page=like" id="num">❤️ <span id="likeCount">' . intval($likeCount) . '</span></a>';

        echo '<section id="two">';
        echo '<h2>🔍 Search results for "' . htmlspecialchars($keyword) . '"</h2>';
        echo '<div class="row">';

        foreach ($books as $book) {
            $img = !empty($book->image_url) ? htmlspecialchars($book->image_url) : 'images/thumbs/default.jpg';
            $name = htmlspecialchars($book->name);
            $author = htmlspecialchars($book->author);
            $desc = nl2br(htmlspecialchars($book->description));
            $price = htmlspecialchars($book->price);
            $id = $book->getID();

            echo '
            <article class="col-6 col-12-xsmall work-item" style="border:1px solid #ccc; padding:10px;">
            <p> '.$id. ' </p>
                <a href="' . $img . '" class="image fit thumb">
                    <img src="' . $img . '" alt="' . $name . '" />
                </a>

                <h3>' . $name . '</h3>
                <p><strong>Author:</strong> ' . $author . '</p>
                <p>' . $desc . '</p>
                <p><strong>Price:</strong> ' . $price . ' €</p>

                <div style="margin-top:10px;">
                    <button class="add-to-cart" data-id="' . htmlspecialchars($id) . '" style="background:#2ecc71; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer;">
                        ➕ Add to Cart
                    </button>
                    <button class="like-button" data-id="' . htmlspecialchars($id) . '"
                     style="background:#e74c3c; color:white; padding:5px 10px; border:none; border-radius:5px; cursor:pointer; margin-left:10px;">
                     ❤️ Like
                     </button>
                </div>
            </article>';
        }

        echo '</div>';
        echo '</section>';
    }
}
