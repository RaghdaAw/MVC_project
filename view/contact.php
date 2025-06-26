<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
     <link rel="stylesheet" href="assets/css/main.css" />

</head>
<body>

<!--        <a class="back-to-home-button" href="/public.php?page=userDashboard"> Back to Home </a>-->
        <h2 class="contact-us-text">Contact Us</h2>
        <form class="contact-form" action="contact.php" method="post">
            <input type="text" name="name" placeholder="Your Name" required>

            <input type="email" name="email" placeholder="Your Email" required>

            <input type="text" name="subject" placeholder="Subject" required>

            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>

            <button type="submit">Send Message</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<p class='success-msg'>✅ Thank you, your message has been sent.</p>";
        }
        ?>

</body>
</html>
