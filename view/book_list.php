<body class="is-preload">
    <div>
        <?php foreach ($books as $row): ?>
            <div class="book-item">
                <p><strong>ID:</strong> <?= $row['product_id']; ?></p>
                <p><strong>Name:</strong> <?= $row['name']; ?></p>
                <p><strong>Author:</strong> <?= $row['author']; ?></p>
                <p><strong>Year:</strong> <?= $row['year']; ?></p>
                <p><strong>Price:</strong> <?= $row['price']; ?></p>
                <p><strong>Description:</strong> <?= $row['description']; ?></p>

                <?php if (!empty($row['image_url'])): ?>
                    <p><img src="<?= $row['image_url']; ?>" alt="Book Image" style="width:100px;height:auto;"></p>
                <?php endif; ?>

                <a href="/MVC-project/MVC_project/controller/admin_delete_book.php?del=<?= $row['product_id']; ?>" 
                   onclick="return confirm('هل أنت متأكد من حذف هذا الكتاب؟');" 
                   class="delete-button">
                    <i class="fa-solid fa-xmark delete"></i> <span>Delete</span>
                </a>

                <hr>
            </div>
        <?php endforeach; ?>
    </div>
</body>
