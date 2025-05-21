

<?php foreach ($books as $book): ?>
  <article class="col-6 col-12-xsmall work-item">
    <img src="<?= $book['image'] ?>" alt="<?= htmlspecialchars($book['title']) ?>" />
    <i class="fa-solid fa-heart"></i>
    <i class="fa-solid fa-cart-plus"></i>
    <h3><?= htmlspecialchars($book['title']) ?></h3>
    <p><?= htmlspecialchars($book['description']) ?></p>
    <p><?= number_format($book['price'], 2) ?> €</p>
  </article>
<?php endforeach; ?>
