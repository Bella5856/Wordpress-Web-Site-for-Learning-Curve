<div class="newsletter">
    <div class="inner">
        <h4>Subscribe to our newsletter</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem eligendi repudiandae officia quos. Nesciunt,
            ea.
        </p>
        <form action="" method="post" id="newsletter-form">
            <?php wp_nonce_field('newsletter_signup', 'newsletter_nonce'); ?>
            <input type="email" name="email_for_newsletter" id="email-for-newsletter"
                placeholder="Enter your email address" required>
            <button type="submit">Save it</button>
        </form>
        <div id="newsletter-response">
            <?php
            // Display success or error messages based on URL query parameters
            if (isset($_GET['newsletter'])) {
                if ($_GET['newsletter'] == 'success') {
                    echo '<p class="newsletter-success">Thank you for subscribing!</p>';
                } elseif ($_GET['newsletter'] == 'error') {
                    if (isset($_GET['error_type']) && $_GET['error_type'] == 'invalid_email') {
                        echo '<p class="newsletter-error">Please enter a valid email address.</p>';
                    } elseif (isset($_GET['error_type']) && $_GET['error_type'] == 'duplicate') {
                        echo '<p class="newsletter-error">This email is already subscribed.</p>';
                    } else {
                        echo '<p class="newsletter-error">There was an error processing your subscription. Please try again later.</p>';
                    }
                }
            }
            ?>
        </div>
    </div>
</div>