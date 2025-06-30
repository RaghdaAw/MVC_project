<?php
class ContactView
{
    public static function renderContactPage($cartCount = 0, $likeCount = 0)
    {
        
        include __DIR__ . '/navbar.php'; 
       ?>
        <h2 class="contact-us-text">Contact Us</h2>
        <form class="contact-form" action="public.php?page=contact" method="post">
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
    }
}
