<!DOCTYPE HTML>
<!--
    Strata by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
    <title>Strata by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">
    <?php
    include '../model/Book.php';
    include '../controller/BookController.php';
    ?>
    <div>
<?php

$myBooks = new Book($pdo);
$books = $myBooks->getAllBooks();
?>

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

        <a href="../controller/admin_delete_book.php?del=<?= $row['product_id']; ?>" 
           onclick="return confirm('هل أنت متأكد من حذف هذا الكتاب؟');" 
           class="delete-button">
            <i class="fa-solid fa-xmark delete"></i> <span>deletet</span>
        </a>

        <hr>
    </div>
<?php endforeach; ?>
<?php
$bookController = new BookController($pdo);

$page = $_GET['page'] ?? 'books';

if ($page === 'books') {
    $bookController->showAllBooks();
}
?>

<?php
    // $row = $selectPost->fetch(PDO::FETCH_ASSOC);
    // $post_text = $row['post_content'];
    // $post_date = $row['post_date'];
    // $post_img = $row['upload_image'];
    // $user_name = $row['Username'];
    // $post_id = $row['post_id'];
    // $user_id = $row['user_id'];
    ?>
    <!-- Header -->
    <!-- <header id="header">
        <div class="inner">
            <a href="#" class="image avatar"><img src="images/cookie.png" alt="" /></a>
            <h1><strong>Welcome,</strong><br />
            </h1>
            <button>Sign In</button>
            <button>Sign Up</button>
        </div>
    </header> -->

    <!-- Main -->
    <!-- <div id="main"> -->

    <!-- One -->
    <!-- <section id="one">
            <header class="major">
                <i class="fa-solid fa-heart"></i>
                <i class="fa-solid fa-cart-plus"></i>
                <h2>Ipsum lorem dolor aliquam ante commodo<br />
                    magna sed accumsan arcu neque.</h2>
            </header>
            <p>Accumsan orci faucibus id eu lorem semper. Eu ac iaculis ac nunc nisi lorem vulputate lorem neque cubilia
                ac in adipiscing in curae lobortis tortor primis integer massa adipiscing id nisi accumsan pellentesque
                commodo blandit enim arcu non at amet id arcu magna. Accumsan orci faucibus id eu lorem semper nunc nisi
                lorem vulputate lorem neque cubilia.</p>
            <ul class="actions">
                <li><a href="#" class="button">Learn More</a></li>
            </ul>
        </section> -->

    <!-- Two -->
    <!-- <section id="two">

            <h2>Recent Work</h2>
            <div class="row">
                <article class="col-6 col-12-xsmall work-item">
                    <a href="images/fulls/01.jpg" class="image fit thumb"><img src="images/thumbs/01.jpg" alt="" /></a>
                    <i class="fa-solid fa-heart"></i>
                    <i class="fa-solid fa-cart-plus"></i>
                    <h3>Magna sed consequat tempus</h3>
                    <p>Lorem ipsum dolor sit amet nisl sed nullam feugiat.</p>
                    <p>35 €</p>
                </article>
                <article class="col-6 col-12-xsmall work-item">
                    <a href="images/fulls/02.jpg" class="image fit thumb"><img src="images/thumbs/02.jpg" alt="" /></a>
                    <h3>Ultricies lacinia interdum</h3>
                    <p>Lorem ipsum dolor sit amet nisl sed nullam feugiat.</p>
                </article>
                <article class="col-6 col-12-xsmall work-item">
                    <a href="images/fulls/03.jpg" class="image fit thumb"><img src="images/thumbs/03.jpg" alt="" /></a>
                    <h3>Tortor metus commodo</h3>
                    <p>Lorem ipsum dolor sit amet nisl sed nullam feugiat.</p>
                </article>
                <article class="col-6 col-12-xsmall work-item">
                    <a href="images/fulls/04.jpg" class="image fit thumb"><img src="images/thumbs/04.jpg" alt="" /></a>
                    <h3>Quam neque phasellus</h3>
                    <p>Lorem ipsum dolor sit amet nisl sed nullam feugiat.</p>
                </article>
                <article class="col-6 col-12-xsmall work-item">
                    <a href="images/fulls/05.jpg" class="image fit thumb"><img src="images/thumbs/05.jpg" alt="" /></a>
                    <h3>Nunc enim commodo aliquet</h3>
                    <p>Lorem ipsum dolor sit amet nisl sed nullam feugiat.</p>
                </article>
                <article class="col-6 col-12-xsmall work-item">
                    <a href="images/fulls/06.jpg" class="image fit thumb"><img src="images/thumbs/06.jpg" alt="" /></a>
                    <h3>Risus ornare lacinia</h3>
                    <p>Lorem ipsum dolor sit amet nisl sed nullam feugiat.</p>
                </article>
            </div>
            <ul class="actions">
                <li><a href="#" class="button">Full Portfolio</a></li>
            </ul>
        </section> -->

    <!-- Three -->
    <!-- <section id="three">
            <h2>Get In Touch</h2>
            <p>Accumsan pellentesque commodo blandit enim arcu non at amet id arcu magna. Accumsan orci faucibus id eu
                lorem semper nunc nisi lorem vulputate lorem neque lorem ipsum dolor.</p>
            <div class="row">
                <div class="col-8 col-12-small">
                    <form method="post" action="#">
                        <div class="row gtr-uniform gtr-50">
                            <div class="col-6 col-12-xsmall"><input type="text" name="name" id="name"
                                    placeholder="Name" /></div>
                            <div class="col-6 col-12-xsmall"><input type="email" name="email" id="email"
                                    placeholder="Email" /></div>
                            <div class="col-12"><textarea name="message" id="message" placeholder="Message"
                                    rows="4"></textarea></div>
                        </div>
                    </form>
                    <ul class="actions">
                        <li><input type="submit" value="Send Message" /></li>
                    </ul>
                </div>
                <div class="col-4 col-12-small">
                    <ul class="labeled-icons">
                        <li>
                            <h3 class="icon solid fa-home"><span class="label">Address</span></h3>
                            1234 Somewhere Rd.<br />
                            Nashville, TN 00000<br />
                            United States
                        </li>
                        <li>
                            <h3 class="icon solid fa-mobile-alt"><span class="label">Phone</span></h3>
                            000-000-0000
                        </li>
                        <li>
                            <h3 class="icon solid fa-envelope"><span class="label">Email</span></h3>
                            <a href="#">hello@untitled.tld</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

    </div> -->

    <!-- Footer -->
    <!-- <footer id="footer">
        <div class="inner">
            <ul class="icons">
                <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon brands fa-github"><span class="label">Github</span></a></li>
                <li><a href="#" class="icon brands fa-dribbble"><span class="label">Dribbble</span></a></li>
                <li><a href="#" class="icon solid fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <ul class="copyright">
                <li>&copy; Raghda & Ni-Yara 2025</li>
            </ul>
        </div>
    </footer> -->

    <!-- Scripts -->
    <!-- <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.poptrox.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script> -->

</body>

</html>