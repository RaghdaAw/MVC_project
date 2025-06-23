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

    public static function renderUserCartList($items)
    {
        echo "<a href='public.php?page=userDashboard'>🔙 Back to Dashboard</a>";
        echo "<h2>🛒 Your Cart</h2>";

        if (empty($items)) {
            echo "<p>No items in cart.</p>";
        } else {
            foreach ($items as $item) {
                echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";

                echo "<p><strong>Quantity:</strong> " . htmlspecialchars($item['quantity']) . "</p>";
                echo "<h3>" . htmlspecialchars($item['name']) . "</h3>";
                echo "<p><strong>Author:</strong> " . htmlspecialchars($item['author']) . "</p>";
                echo "<p><strong>Year:</strong> " . htmlspecialchars($item['year']) . "</p>";
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($item['price']) . "</p>";
                echo "<p><strong>Description:</strong><br>" . nl2br(htmlspecialchars($item['description'])) . "</p>";

                if (!empty($item['image_url'])) {
                    echo "<p><img src='" . htmlspecialchars($item['image_url']) . "' alt='Book Image' style='width:100px; height:auto;'></p>";
                }

      echo "<a href='public.php?page=removeFromCart&cart_id=" . $item['cart_id'] . "' onclick='return confirm(\"Are you sure you want to remove this item?\")'>🗑️ Remove</a>";

                echo "</div>";
            }
        }
    }
}
?>
