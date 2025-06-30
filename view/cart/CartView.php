<link rel="stylesheet" href="/view/assets/css/main.css">
<?php
class CartView
{
    public static function renderCart($items)
    {
        foreach ($items as $book) {
            $img = $book['image_url'] ? "<img src='" . htmlspecialchars($book['image_url']) . "' width='100' alt='Book Image'>" : "No image";
            echo "
                <div style='border:1px solid #ddd; padding:10px; margin-bottom:10px;'>
                    <div>{$img}</div>
                    <h3>" . htmlspecialchars($book['name']) . "</h3>
                    <p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>
                    <p><strong>Year:</strong> " . htmlspecialchars($book['year']) . "</p>
                    <p><strong>Price:</strong> $" . htmlspecialchars($book['price']) . "</p>
                    <p>" . nl2br(htmlspecialchars($book['description'])) . "</p>
                </div>
            ";
        }
    }

    public static function renderUserCartList($items, $cartCount, $likeCount)
    {

        // echo "<a class='back-to-home' href='public.php?page=userDashboard'>🔙 Back to Home</a>";
            include __DIR__ . '/../navbar.php';

        echo "<h2 class='your-cart-text'>🛒 Your Cart</h2>";

        echo '<section id="two">';
        echo '<div class="cart-row">';

        if (empty($items)) {
            echo "<p class='no-items-cart' >No items in cart.</p>";
        } else {
            echo "<div class='cart-book-cards'>"; // ✅ Start grid container outside the loop

            foreach ($items as $item) {
                echo "<div class='cart-book-card'>";

                echo "<div class='cart-book-info'>";
                if (!empty($item['image_url'])) {
                    echo "<p><img src='" . htmlspecialchars($item['image_url']) . "' alt='Book Image' style='width:100px; height:auto;'></p>";
                }
                echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($item['author']) . "</p>";
                echo "<p>€ " . htmlspecialchars($item['price']) . "</p>";
                echo "<p class='quantity-count'>" . htmlspecialchars($item['quantity']) . "</p>";
                echo "<br>";
                echo "<a class='cart-remove' href='public.php?page=removeFromCart&cart_id=" . $item['cart_id'] . "' onclick='return confirm(\"Are you sure you want to remove this item?\")'>🗑️ Remove</a>";

                echo "</div>"; // close book-info
                echo "</div>"; // close book-card
            }

            echo "</div>"; // ✅ Close grid container after the loop
        }

        echo "</div>"; // close row
        echo "</section>"; // close section
    }

}
?>
