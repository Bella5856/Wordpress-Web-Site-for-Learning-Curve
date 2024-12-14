<?php

/*
Template Name:My Account
*/ ?>

<?php
// Start by checking if the user is logged in
if (is_user_logged_in()) {
    // Define the URL to redirect to. Replace '/membership' with your actual membership page slug or URL.
    $membership_page_url = home_url('/membership'); // Example: https://yourwebsite.com/membership

    // Perform the redirection
    wp_safe_redirect($membership_page_url);
    exit; // Always call exit() after redirect to prevent further execution
}

get_header();
?>

<?php
get_header();
?>

<div class="container container-section">
    <div class="my-account-content">
        <!-- Toggle Buttons -->
        <div class="account-toggle-buttons">
            <button id="show-login" class="active">Log In</button>
            <button id="show-register">Sign Up</button>
        </div>

        <!-- WooCommerce My Account Shortcode -->
        <?php echo do_shortcode('[woocommerce_my_account]'); ?>
    </div>
</div>

<?php
get_footer();
?>