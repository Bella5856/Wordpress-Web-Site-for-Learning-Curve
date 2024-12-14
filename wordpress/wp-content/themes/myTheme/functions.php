<?php

function enqueue_bootstrap()
{
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

function load_css()
{

    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), false, 'all');

    wp_enqueue_style('bootstrap');

    wp_register_style('main', get_template_directory_uri() . '/css/main.css', array(), false, 'all');

    wp_enqueue_style('main');
}

add_action('wp_enqueue_scripts', 'load_css');

function load_js()
{
    wp_enqueue_script('jquery');
    wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap');
}
add_action('wp_enqueue_scripts', 'load_js');


add_theme_support('menus');
add_theme_support('post-thumbnails');

register_nav_menus(
    array('nav-bar' => 'Nav Bar', 'mobile-menu' => 'Mobile Menu Location', 'footer-menu' => 'Footer Menu')

);


function enqueue_account_toggle_script()
{
    if (is_account_page()) {
        wp_enqueue_script('account-toggle', get_stylesheet_directory_uri() . '/js/account-toggle.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_account_toggle_script');


//CPT SECTION


// Include custom post type functions

require get_template_directory() . '/includes/functions/cpt-blog.php';
require get_template_directory() . '/includes/functions/cpt-about.php';
require get_template_directory() . '/includes/functions/cpt-courses.php';
require get_template_directory() . '/includes/functions/cpt-guides.php';
require get_template_directory() . '/includes/functions/cpt-resources.php';
require get_template_directory() . '/includes/functions/cpt-events.php';
require get_template_directory() . '/includes/functions/cpt-conference.php';
require get_template_directory() . '/includes/functions/cpt-cohorts.php';
require get_template_directory() . '/includes/functions/cpt-faq.php';
require get_template_directory() . '/includes/functions/cpt-testimonials.php';





function add_custom_post_types_to_homepage($query)
{
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('post_type', array('post', 'blog'));
    }
}
add_action('pre_get_posts', 'add_custom_post_types_to_homepage');

//LOAD MORE

function enqueue_load_more_scripts()
{
    wp_enqueue_script('load-more', get_template_directory_uri() . '/js/load-more.js', array('jquery'), null, true);

    // Pass the AJAX URL and other variables to the script
    wp_localize_script('load-more', 'load_more_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'current_page' => get_query_var('paged') ? get_query_var('paged') : 1
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_scripts');


function load_more_posts()
{
    // Check if page number is set
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    // Define the query arguments
    $args = array(
        'post_type' => 'blog',
        'posts_per_page' => 6,
        'paged' => $paged
    );

    // Custom query
    $query = new WP_Query($args);

    // Check if there are posts
    if ($query->have_posts()) {
        $post_counter = 0;

        while ($query->have_posts()) {
            $query->the_post();

            $author_id = get_the_author_meta('ID');
            $author_avatar = get_avatar($author_id, 96);
            $post_id = get_the_ID();
            $reading_time = get_reading_time($post_id);
            $categories = wp_get_post_terms(get_the_ID(), 'blog_category', array('fields' => 'slugs'));
            $tags = wp_get_post_terms(get_the_ID(), 'blog_tags', array('fields' => 'slugs'));
            ?>

            <div class="col-md-4 post-item" data-categories="<?php echo esc_attr(implode(',', $categories)); ?>"
                data-tags="<?php echo esc_attr(implode(',', $tags)); ?>">
                <div class="card mb-4 blog-card">
                    <div class="card-body">
                        <?php if (has_post_thumbnail()): ?>
                            <img class="blog-card-img" src="<?php the_post_thumbnail_url(); ?>" class="card-img-top"
                                alt="<?php the_title(); ?>">
                        <?php endif; ?>

                        <div class="blog-author">
                            <div class="author-avatar">
                                <?php echo $author_avatar; ?>
                            </div>
                            <div class="author">
                                <p><small><?php echo get_the_author(); ?></small></p>
                                <p><small><?php echo get_the_date(); ?></small></p>
                            </div>
                        </div>

                        <h3 class="card-title mb-3"><?php the_title(); ?></h3>

                        <!-- Trim the excerpt to match the static post length -->
                        <div class="card-text mb-3">
                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); // Adjust the number 20 to your desired excerpt length ?>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="text-primary fw-semibold">Read more <i
                                class="fa-solid fa-angles-right"></i></a>

                        <div class="post-meta">
                            <span class="reading-time"><?php echo esc_html($reading_time); ?> min read</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6"><img src="<?php echo get_template_directory_uri(); ?> ../Images/line-blue.png"
                                alt="line"></div>
                    </div>
                </div>
            </div>

            <?php
            $post_counter++;
        }

    }
    // Reset post data
    wp_reset_postdata();

    // End AJAX request
    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');


function get_reading_time($post_id)
{
    // Average reading speed in words per minute
    $words_per_minute = 200;

    // Get the post content
    $post_content = get_post_field('post_content', $post_id);

    // Count the number of words
    $word_count = str_word_count(strip_tags($post_content));

    // Calculate reading time
    $reading_time = ceil($word_count / $words_per_minute);

    return $reading_time;
}


// Redirect logged-in users from My Account to Membership page
function redirect_logged_in_users_from_my_account()
{
    if (is_account_page() && is_user_logged_in()) {
        // Define the Membership page URL. Replace '/membership' with your actual page slug or URL.
        $membership_page_url = home_url('/membership'); // Example: https://yourwebsite.com/membership

        // Perform the redirection
        wp_safe_redirect($membership_page_url);
        exit; // Always call exit() after redirect to prevent further execution
    }
}
add_action('template_redirect', 'redirect_logged_in_users_from_my_account');
?>

<?php
// Add First Name and Last Name to WooCommerce Registration Form
function add_custom_registration_fields()
{
    ?>
    <p class="form-row form-row-first">
        <label for="reg_first_name"><?php _e('First Name', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="first_name" id="reg_first_name" autocomplete="given-name" value="<?php if (!empty($_POST['first_name']))
            echo esc_attr(wp_unslash($_POST['first_name'])); ?>" />
    </p>
    <p class="form-row form-row-last">
        <label for="reg_last_name"><?php _e('Last Name', 'woocommerce'); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="last_name" id="reg_last_name" autocomplete="family-name" value="<?php if (!empty($_POST['last_name']))
            echo esc_attr(wp_unslash($_POST['last_name'])); ?>" />
    </p>
    <div class="clear"></div>
    <?php
}
add_action('woocommerce_register_form_start', 'add_custom_registration_fields');
?>

<?php
// Validate Custom Registration Fields
function validate_custom_registration_fields($errors, $username, $email)
{
    if (isset($_POST['first_name']) && empty($_POST['first_name'])) {
        $errors->add('first_name_error', __('First name is required!', 'woocommerce'));
    }
    if (isset($_POST['last_name']) && empty($_POST['last_name'])) {
        $errors->add('last_name_error', __('Last name is required!', 'woocommerce'));
    }
    return $errors;
}
add_filter('woocommerce_registration_errors', 'validate_custom_registration_fields', 10, 3);
?>

<?php
// Save Custom Registration Fields
function save_custom_registration_fields($customer_id)
{
    if (isset($_POST['first_name'])) {
        update_user_meta($customer_id, 'first_name', sanitize_text_field(wp_unslash($_POST['first_name'])));
    }
    if (isset($_POST['last_name'])) {
        update_user_meta($customer_id, 'last_name', sanitize_text_field(wp_unslash($_POST['last_name'])));
    }
}
add_action('woocommerce_created_customer', 'save_custom_registration_fields');
?>

<?php
// Display First Name and Last Name in My Account Dashboard
function display_user_names_in_account_dashboard()
{
    $user_id = get_current_user_id();
    $first_name = get_user_meta($user_id, 'first_name', true);
    $last_name = get_user_meta($user_id, 'last_name', true);

    if ($first_name || $last_name) {
        echo '<p><strong>' . __('Name:', 'woocommerce') . '</strong> ' . esc_html($first_name . ' ' . $last_name) . '</p>';
    }
}
add_action('woocommerce_account_dashboard', 'display_user_names_in_account_dashboard');
?>
<?php
function wc_redirect_to_checkout_after_add_to_cart($url)
{
    return wc_get_checkout_url();
}
add_filter('woocommerce_add_to_cart_redirect', 'wc_redirect_to_checkout_after_add_to_cart');
?>

<?php
// Enforce single product in cart
function wc_enforce_single_product_in_cart($passed, $product_id, $quantity, $variation_id = '', $variations = array(), $cart_item_data = array())
{
    if (WC()->cart->get_cart_contents_count() > 0) {
        // Remove all other items from the cart
        WC()->cart->empty_cart();
    }
    return $passed;
}
add_filter('woocommerce_add_to_cart_validation', 'wc_enforce_single_product_in_cart', 10, 6);
?>
<?php
// Change "Add to Cart" button text to "Buy Now"
function wc_change_add_to_cart_text($text)
{
    if ('Add to cart' === $text) {
        $text = __('Buy Now', 'woocommerce');
    }
    return $text;
}
add_filter('woocommerce_product_single_add_to_cart_text', 'wc_change_add_to_cart_text');
add_filter('woocommerce_product_add_to_cart_text', 'wc_change_add_to_cart_text');
?>

<?php
// Redirect logged-in users from My Account to Membership page
function wc_redirect_logged_in_users_from_my_account()
{
    if (is_account_page() && is_user_logged_in()) {
        // Define the Membership page URL. Replace '/membership' with your actual page slug or URL.
        $membership_page_url = home_url('/membership'); // Example: https://yourwebsite.com/membership

        // Perform the redirection
        wp_safe_redirect($membership_page_url);
        exit; // Always call exit() after redirect to prevent further execution
    }
}
add_action('template_redirect', 'wc_redirect_logged_in_users_from_my_account');

// Redirect users to Membership page after successful login
function wc_redirect_after_login_to_membership($redirect, $user)
{
    // Define the Membership page URL. Replace '/membership' with your actual page slug or URL.
    $membership_page_url = home_url('/membership'); // Example: https://yourwebsite.com/membership

    // Optional: Check for specific user roles (e.g., 'customer')
    if (in_array('customer', (array) $user->roles)) {
        return $membership_page_url;
    }

    // For all other roles, return the original redirect URL
    return $redirect;
}
add_filter('woocommerce_login_redirect', 'wc_redirect_after_login_to_membership', 10, 2);

// Redirect non-logged-in users accessing Membership page to My Account
function wc_redirect_non_logged_in_users_from_membership()
{
    if (is_page_template('template-membership.php') && !is_user_logged_in()) {
        // Define the My Account page URL. Replace '/my-account' with your actual My Account page slug or URL.
        $my_account_page_url = home_url('/my-account'); // Example: https://yourwebsite.com/my-account

        // Perform the redirection
        wp_safe_redirect($my_account_page_url);
        exit; // Always call exit() after redirect to prevent further execution
    }
}
add_action('template_redirect', 'wc_redirect_non_logged_in_users_from_membership');
?>
<?php
function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');
?>



<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Handle "Save Your Spot" form submissions with PRG pattern.
 */
function handle_save_your_spot_form_submission()
{
    // Check if form is submitted
    if (isset($_POST['save_your_spot_email'])) {
        // Check the nonce for security
        if (!isset($_POST['save_your_spot_nonce']) || !wp_verify_nonce($_POST['save_your_spot_nonce'], 'save_your_spot_action')) {
            // Redirect with security error
            wp_redirect(add_query_arg(array(
                'save_spot' => 'error',
                'error_type' => 'nonce_failed'
            ), get_permalink()));
            exit;
        }

        // Sanitize and validate the email
        $email = sanitize_email($_POST['save_your_spot_email']);

        if (!is_email($email)) {
            // Redirect with invalid email error
            wp_redirect(add_query_arg(array(
                'save_spot' => 'error',
                'error_type' => 'invalid_email'
            ), get_permalink()));
            exit;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'save_your_spot';

        // Check if the email already exists
        $existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table_name WHERE email = %s", $email));

        if ($existing_email) {
            // Redirect with duplicate email error
            wp_redirect(add_query_arg(array(
                'save_spot' => 'error',
                'error_type' => 'duplicate'
            ), get_permalink()));
            exit;
        }

        // Insert the email into the database
        $inserted = $wpdb->insert(
            $table_name,
            array(
                'email' => $email,
                // 'submitted_at' will automatically use the current timestamp
            ),
            array(
                '%s',
            )
        );

        if ($inserted) {
            // Redirect with success message
            wp_redirect(add_query_arg('save_spot', 'success', get_permalink()));
            exit;
        } else {
            // Redirect with general error
            wp_redirect(add_query_arg('save_spot', 'error', get_permalink()));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_save_your_spot_form_submission');
?>

<?php
/**
 * Handle newsletter form submissions with PRG pattern.
 */
function handle_newsletter_form_submission()
{
    // Check if form is submitted
    if (isset($_POST['email_for_newsletter'])) {
        // Check the nonce for security
        if (!isset($_POST['newsletter_nonce']) || !wp_verify_nonce($_POST['newsletter_nonce'], 'newsletter_signup')) {
            // Redirect with security error
            wp_redirect(add_query_arg(array(
                'newsletter' => 'error',
                'error_type' => 'nonce_failed'
            ), get_permalink()));
            exit;
        }

        // Sanitize and validate the email
        $email = sanitize_email($_POST['email_for_newsletter']);

        if (!is_email($email)) {
            // Redirect with invalid email error
            wp_redirect(add_query_arg(array(
                'newsletter' => 'error',
                'error_type' => 'invalid_email'
            ), get_permalink()));
            exit;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'newsletter_subscribers';

        // Check if the email already exists
        $existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table_name WHERE email = %s", $email));

        if ($existing_email) {
            // Redirect with duplicate email error
            wp_redirect(add_query_arg(array(
                'newsletter' => 'error',
                'error_type' => 'duplicate'
            ), get_permalink()));
            exit;
        }

        // Insert the email into the database
        $inserted = $wpdb->insert(
            $table_name,
            array(
                'email' => $email,
                // 'subscribed_at' will automatically use the current timestamp
            ),
            array(
                '%s',
            )
        );

        if ($inserted) {
            // Redirect with success message
            wp_redirect(add_query_arg('newsletter', 'success', get_permalink()));
            exit;
        } else {
            // Redirect with general error
            wp_redirect(add_query_arg('newsletter', 'error', get_permalink()));
            exit;
        }
    }
}
add_action('template_redirect', 'handle_newsletter_form_submission');
?>

<?php
/**
 * Enqueue AJAX script for forms.
 */
function enqueue_custom_ajax_scripts()
{
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/js/custom-ajax.js', array('jquery'), '1.0', true);

    // Localize script with AJAX URL and nonce
    wp_localize_script('custom-ajax', 'custom_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('custom_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_ajax_scripts');
?>

<?php
/**
 * Handle AJAX request for "Save Your Spot" form submission.
 */
function handle_save_your_spot_ajax()
{
    // Check the nonce for security
    if (!isset($_POST['save_your_spot_nonce']) || !wp_verify_nonce($_POST['save_your_spot_nonce'], 'custom_ajax_nonce')) {
        echo '<p class="save-your-spot-error">Security check failed. Please try again.</p>';
        wp_die();
    }

    // Check if email is set
    if (isset($_POST['email_for_save_your_spot'])) {
        // Sanitize and validate the email
        $email = sanitize_email($_POST['email_for_save_your_spot']);

        if (!is_email($email)) {
            echo '<p class="save-your-spot-error">Please enter a valid email address.</p>';
            wp_die();
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'save_your_spot';

        // Check if the email already exists
        $existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table_name WHERE email = %s", $email));

        if ($existing_email) {
            echo '<p class="save-your-spot-error">This email is already saved.</p>';
            wp_die();
        }

        // Insert the email into the database
        $inserted = $wpdb->insert(
            $table_name,
            array(
                'email' => $email,
                // 'submitted_at' will automatically use the current timestamp
            ),
            array(
                '%s',
            )
        );

        if ($inserted) {
            echo '<p class="save-your-spot-success">Thank you! Your spot has been saved.</p>';
        } else {
            echo '<p class="save-your-spot-error">There was an error saving your spot. Please try again later.</p>';
        }
    }

    wp_die(); // Always terminate AJAX handlers with wp_die()
}
add_action('wp_ajax_handle_save_your_spot_ajax', 'handle_save_your_spot_ajax');
add_action('wp_ajax_nopriv_handle_save_your_spot_ajax', 'handle_save_your_spot_ajax');

/**
 * Handle AJAX request for Newsletter form submission.
 */
function handle_newsletter_ajax()
{
    // Check the nonce for security
    if (!isset($_POST['newsletter_nonce']) || !wp_verify_nonce($_POST['newsletter_nonce'], 'custom_ajax_nonce')) {
        echo '<p class="newsletter-error">Security check failed. Please try again.</p>';
        wp_die();
    }

    // Check if email is set
    if (isset($_POST['email_for_newsletter'])) {
        // Sanitize and validate the email
        $email = sanitize_email($_POST['email_for_newsletter']);

        if (!is_email($email)) {
            echo '<p class="newsletter-error">Please enter a valid email address.</p>';
            wp_die();
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'newsletter_subscribers';

        // Check if the email already exists
        $existing_email = $wpdb->get_var($wpdb->prepare("SELECT email FROM $table_name WHERE email = %s", $email));

        if ($existing_email) {
            echo '<p class="newsletter-error">This email is already subscribed.</p>';
            wp_die();
        }

        // Insert the email into the database
        $inserted = $wpdb->insert(
            $table_name,
            array(
                'email' => $email,
                // 'subscribed_at' will automatically use the current timestamp
            ),
            array(
                '%s',
            )
        );

        if ($inserted) {
            echo '<p class="newsletter-success">Thank you for subscribing!</p>';
        } else {
            echo '<p class="newsletter-error">There was an error processing your subscription. Please try again later.</p>';
        }
    }

    wp_die(); // Always terminate AJAX handlers with wp_die()
}
add_action('wp_ajax_handle_newsletter_ajax', 'handle_newsletter_ajax');
add_action('wp_ajax_nopriv_handle_newsletter_ajax', 'handle_newsletter_ajax');
?>