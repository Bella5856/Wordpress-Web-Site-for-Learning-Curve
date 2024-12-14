<?php

/*
Template Name:Membership
*/ ?>
<?php
if (!is_user_logged_in()) {
    // Define the My Account page URL. Replace '/my-account' with your actual My Account page slug or URL.
    $my_account_page_url = home_url('/my-account'); // Example: https://yourwebsite.com/my-account

    // Perform the redirection
    wp_safe_redirect($my_account_page_url);
    exit; // Always call exit() after redirect to prevent further execution
}
?>

<?php get_header(); ?>

<div class="container container-section">
    <div class="membership-content">
        <h1>Your Purchased Courses</h1>
        <?php
        // Display the purchased courses using the shortcode
        echo do_shortcode('[purchased_courses]');
        ?>
    </div>
</div>
<?php get_footer(); ?>