<?php
class LikeView
{
    public static function renderLiket($items)
    {

        foreach ($items as $book) {
            $img = $book['image_url'] ? "<img src='{$book['image_url']}' width='100'>" : "No image";
            echo "
                {$img}
                {$book['name']}
                {$book['author']}
                {$book['year']}
                {$book['price']}
                {$book['description']}
              
              
            ";
        }
    }
  
    public static function renderUserLikeList($items)
    {
        echo " <a href='public.php?page=userDashboard'>🔙</a>";
        echo "<h2>❤️ Your Like</h2>";

        if (empty($items)) {
            echo "<p>No items in Like.</p>";
        } else {
            foreach ($items as $item) {
                echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";

                echo "<p><strong>ID:</strong> {$item['product_id']}</p>";
                echo "<p><strong>Name:</strong> " . htmlspecialchars($item['name']) . "</p>";
                echo "<p><strong>Author:</strong> " . htmlspecialchars($item['author']) . "</p>";
                echo "<p><strong>Year:</strong> {$item['year']}</p>";
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($item['price']) . "</p>";
                echo "<p><strong>Description:</strong> " . nl2br(htmlspecialchars($item['description'])) . "</p>";

                if (!empty($item['image_url'])) {
                    echo "<p><img src='{$item['image_url']}' alt='Book Image' style='width:100px;height:auto;'></p>";
                }

                echo "<a href='?page=removeFromLike&idlike={$item['like_id']}' onclick='return confirm(\"Are you sure?\")'>🗑️ Remove</a>";

                echo "</div>";
            }
        }
    }
}

?>