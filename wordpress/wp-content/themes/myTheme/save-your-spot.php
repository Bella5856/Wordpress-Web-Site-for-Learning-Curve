<div class="newsletter">
    <div class="inner">
        <h4>Save Your Spot</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem eligendi repudiandae officia quos. Nesciunt,
            ea.
        </p>
        <form action="" method="post" id="save-your-spot-form">
            <?php wp_nonce_field('save_your_spot_action', 'save_your_spot_nonce'); ?>
            <input type="email" name="save_your_spot_email" id="save-your-spot-email"
                placeholder="Enter your email address" required>
            <button type="submit">Save it</button>
        </form>
        <div id="save-your-spot-response">
            <?php
            // Display success or error messages based on URL query parameters
            if (isset($_GET['save_spot'])) {
                if ($_GET['save_spot'] == 'success') {
                    echo '<p class="save-your-spot-success">Thank you! Your spot has been saved.</p>';
                } elseif ($_GET['save_spot'] == 'error') {
                    if (isset($_GET['error_type']) && $_GET['error_type'] == 'invalid_email') {
                        echo '<p class="save-your-spot-error">Please enter a valid email address.</p>';
                    } elseif (isset($_GET['error_type']) && $_GET['error_type'] == 'duplicate') {
                        echo '<p class="save-your-spot-error">This email is already saved.</p>';
                    } else {
                        echo '<p class="save-your-spot-error">There was an error saving your spot. Please try again later.</p>';
                    }
                }
            }
            ?>
        </div>
    </div>
</div>