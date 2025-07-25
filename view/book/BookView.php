<link rel="stylesheet" href="/view/assets/css/main.css" />
<?php

class BookView
{
    public static function renderBookList($books)
    {
        include __DIR__ . '/../navbarAdmin.php';
        ?>


        <h2>📚 All Books</h2>


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
                            <a href="public.php?page=deleteBook&id=<?= urlencode($book->getID()) ?>" class="delete-btn"
                                onclick="return confirm('Are you sure?')">🗑 Delete</a>
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
        <form method="POST" action="public.php?page=updateBook&id=<?= urlencode($book->getID()); ?>"
            enctype="multipart/form-data">
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
    if (isset($_SESSION['user_id'])) {
        
        // $cartCount = intval($cartCount);
        // $likeCount = intval($likeCount);
        include __DIR__ . '/../navbar.php';
        include __DIR__ . '/../book_hello.php';
    } else {
        include __DIR__ . '/../navbar_guest.php';
        include __DIR__ . '/../book_hello.php';
    }
        echo '<section id="two">';
        echo '<h2>📘 Books</h2>';
        echo '<div class="row">';
        foreach ($books as $book) {
            $img = !empty($book->image_url) ? htmlspecialchars($book->image_url) : 'images/thumbs/default.jpg';
            $name = htmlspecialchars($book->name);
            $author = htmlspecialchars($book->author);
            $desc = nl2br(htmlspecialchars($book->description));
            $price = htmlspecialchars($book->price);
            $id_product = $book->getID(); ?>
            <article class="work-item">
                 
                <a href="<?= $img ?>" class="image fit thumb"> <img src="<?= $img ?>" alt="<?= $name ?>" /> </a>
                <h3><?= $name ?></h3>
                <p class="author-text"><?= $author ?></p>
                <p class="desc-text"><?= $desc ?></p>
                <p class="price-text"><strong>€ <?= $price ?></strong></p>
                <div> <?php if (isset($_SESSION['user_id'])): ?> <button class="add-to-cart"
                            data-id="<?= htmlspecialchars($id_product) ?>"> ➕ Add to Cart </button> <button class="like-button"
                            data-id="<?= htmlspecialchars($id_product) ?>"> ❤️ Like </button> <?php else: ?>
                

                        <p class="warning">Log in to add books to your cart or like it.</p> <?php endif; ?>
                </div>
            </article>
        <?php }
        echo '</div>';
        echo '</section>';
        echo '<section id="about">';
        include __DIR__ . '/../about.php';
        echo '</section>';
        include __DIR__ . '/../footer.php';
    }
   public static function renderSearchResults($books, $keyword, $cartCount = 0, $likeCount = 0)
{
    if (isset($_SESSION['user_id'])) {
        include __DIR__ . '/../navbar.php';
        include __DIR__ . '/../book_hello.php';
    } else {
        include __DIR__ . '/../navbar_guest.php';
        include __DIR__ . '/../book_hello.php';
    }

    echo '<section id="two">';
    echo '<h2>🔍 Search results for "' . htmlspecialchars($keyword) . '"</h2>';
    echo '<div class="row">';

    foreach ($books as $book) {
        $img = !empty($book->image_url) ? htmlspecialchars($book->image_url) : 'images/thumbs/default.jpg';
        $name = htmlspecialchars($book->name);
        $author = htmlspecialchars($book->author);
        $desc = nl2br(htmlspecialchars($book->description));
        $price = htmlspecialchars($book->price);
        $id_product = $book->getID();
        ?>
        <article class="col-6 col-12-xsmall work-item">
            <a href="<?= $img ?>" class="image fit thumb">
                <img src="<?= $img ?>" alt="<?= $name ?>" />
            </a>
            <h3><?= $name ?></h3>
            <p class="author-text"><?= $author ?></p>
            <p class="desc-text"><?= $desc ?></p>
            <p class="price-text"><strong>€ <?= $price ?></strong></p>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button class="add-to-cart" data-id="<?= htmlspecialchars($id_product) ?>">➕ Add to Cart</button>
                    <button class="like-button" data-id="<?= htmlspecialchars($id_product) ?>">❤️ Like</button>
                <?php else: ?>
                    <p  class="warning">Log in to add books to your cart or like it.</p>
                <?php endif; ?>
            </div>
        </article>
        <?php
    }

    echo '</div>';
    echo '</section>';
}



}
