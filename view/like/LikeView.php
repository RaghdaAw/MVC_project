
<?php
class LikeView
{
    // عرض العناصر بشكل بسيط (لم يُستخدم في الكود الحالي غالباً)
    public static function renderLiket($items)
    {
        foreach ($items as $book) {
            $img = $book['image_url'] 
                ? "<img src='" . htmlspecialchars($book['image_url']) . "' width='100'>" 
                : "No image";

            echo "
                <div style='margin-bottom: 10px; border: 1px solid #ccc; padding: 10px;'>
                    {$img}<br>
                    <strong>Name:</strong> " . htmlspecialchars($book['name']) . "<br>
                    <strong>Author:</strong> " . htmlspecialchars($book['author']) . "<br>
                    <strong>Year:</strong> " . (int)$book['year'] . "<br>
                    <strong>Price:</strong> $" . htmlspecialchars($book['price']) . "<br>
                    <strong>Description:</strong> " . nl2br(htmlspecialchars($book['description'])) . "<br>
                </div>
            ";
        }
    }

   
    public static function renderUserLikeList($items)
{
    // echo "<a class='back-to-home' href='public.php?page=userDashboard'>🔙 Back to Home</a>";
            include __DIR__ . '/../navbar.php';

    echo "<h2 class='your-cart-text'>❤️ Your Favorites</h2>";

    echo '<section id="two">';
    echo '<div class="cart-row">';

    if (empty($items)) {
        echo "<p class='no-items-cart'>No items in favorites.</p>";
    } else {
        echo "<div class='cart-book-cards'>"; // Start grid container outside the loop

        foreach ($items as $item) {
            echo "<div class='cart-book-card'>";

            echo "<div class='cart-book-info'>";
            if (!empty($item['image_url'])) {
                echo "<p><img src='" . htmlspecialchars($item['image_url']) . "' alt='Book Image' style='width:100px; height:auto;'></p>";
            }
            echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
            echo "<p>" . htmlspecialchars($item['author']) . "</p>";
            echo "<p>€ " . htmlspecialchars($item['price']) . "</p>";
            echo "<br>";
            echo "<a class='cart-remove' href='public.php?page=removeFromLike&like_id=" . $item['like_id'] . "' onclick='return confirm(\"Are you sure you want to remove this item from favorites?\")'>🗑️ Remove</a>";

            echo "</div>"; // close book-info
            echo "</div>"; // close book-card
        }

        echo "</div>"; // Close grid container after the loop
    }

    echo "</div>"; // close row
    echo "</section>"; // close section
}
}
?>
