
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

    // عرض قائمة الإعجابات للمستخدم
    public static function renderUserLikeList($items)
    {
        echo "<a href='public.php?page=userDashboard'>🔙 Back to Dashboard</a>";
        echo "<h2>❤️ Your Liked Books</h2>";

        if (empty($items)) {
            echo "<p>No items in Like.</p>";
        } else {
            foreach ($items as $item) {
                echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";

                echo "<p><strong>ID:</strong> " . (int)$item['product_id'] . "</p>";
                echo "<p><strong>Name:</strong> " . htmlspecialchars($item['name']) . "</p>";
                echo "<p><strong>Author:</strong> " . htmlspecialchars($item['author']) . "</p>";
                echo "<p><strong>Year:</strong> " . (int)$item['year'] . "</p>";
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($item['price']) . "</p>";
                echo "<p><strong>Description:</strong> " . nl2br(htmlspecialchars($item['description'])) . "</p>";

                if (!empty($item['image_url'])) {
                    $safeImage = htmlspecialchars($item['image_url']);
                    echo "<p><img src='{$safeImage}' alt='Book Image' style='width:100px;height:auto;'></p>";
                }

                echo "<a href='?page=removeFromLike&idlike={$item['like_id']}' 
                          onclick='return confirm(\"Are you sure you want to remove this item from your likes?\")'>
                          🗑️ Remove</a>";

                echo "</div>";
            }
        }
    }
}
?>
