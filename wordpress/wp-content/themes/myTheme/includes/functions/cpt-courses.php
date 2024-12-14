<?php

// Register Courses Custom Post Type
function post_type_courses()
{
    $args = array(
        'labels' => array(
            'name' => 'Courses',
            'singular_name' => 'Course',
            'menu_name' => 'Courses',
            'name_admin_bar' => 'Course',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Course',
            'new_item' => 'New Course',
            'edit_item' => 'Edit Course',
            'view_item' => 'View Course',
            'all_items' => 'All Courses',
            'search_items' => 'Search Courses',
            'parent_item_colon' => 'Parent Courses:',
            'not_found' => 'No courses found.',
            'not_found_in_trash' => 'No courses found in Trash.',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'courses'),
        'show_in_rest' => true, // Enable Gutenberg support
    );
    register_post_type('courses', $args);
}
add_action('init', 'post_type_courses');


// Hook to add meta boxes
add_action('add_meta_boxes', 'add_courses_meta_boxes');

function add_courses_meta_boxes()
{
    add_meta_box(
        'course_features',
        'Course Features',
        'render_course_features_meta_box',
        'courses',
        'normal',
        'high'
    );

    add_meta_box(
        'financial_options',
        'Financial Options',
        'render_financial_options_meta_box',
        'courses',
        'normal',
        'high'
    );

    add_meta_box(
        'mentors',
        'Mentors',
        'render_mentors_meta_box',
        'courses',
        'normal',
        'high'
    );

    add_meta_box(
        'course_link',
        'Course Link',
        'render_course_link_meta_box',
        'courses',
        'side',
        'high'
    );

    add_meta_box(
        'course_video_link',
        'Course Video Link',
        'render_course_video_link_meta_box',
        'courses',
        'side',
        'high'
    );

    add_meta_box(
        'course_product_meta',
        'WooCommerce Product',
        'render_course_product_meta_box',
        'courses',
        'side',
        'default'
    );
}


// Render Course Features Meta Box
function render_course_features_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_course_features', 'course_features_nonce');

    // Retrieve existing features
    $course_features = get_post_meta($post->ID, 'course_features', true);
    $course_features = !empty($course_features) ? json_decode($course_features, true) : [];
    ?>
    <div id="course-features-container">
        <?php foreach ($course_features as $index => $feature): ?>
            <div class="course-feature">
                <hr>
                <h4>Feature <?php echo $index + 1; ?></h4>
                <label for="course_features[<?php echo $index; ?>][name]">Feature Name:</label>
                <input type="text" name="course_features[<?php echo $index; ?>][name]"
                    value="<?php echo esc_attr($feature['name']); ?>" class="widefat" placeholder="Enter feature name">

                <label for="course_features[<?php echo $index; ?>][description]">Feature Description:</label>
                <textarea name="course_features[<?php echo $index; ?>][description]" class="widefat"
                    placeholder="Enter feature description"><?php echo esc_textarea($feature['description']); ?></textarea>

                <button type="button" class="button remove-course-feature">Remove Feature</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-course-feature" class="button">Add Feature</button>

    <script>
        jQuery(document).ready(function ($) {
            $('#add-course-feature').on('click', function (e) {
                e.preventDefault();
                var container = $('#course-features-container');
                var index = container.children('.course-feature').length;
                var newFeature = `
                        <div class="course-feature">
                            <hr>
                            <h4>Feature ${index + 1}</h4>
                            <label for="course_features[${index}][name]">Feature Name:</label>
                            <input type="text" name="course_features[${index}][name]" class="widefat" placeholder="Enter feature name">

                            <label for="course_features[${index}][description]">Feature Description:</label>
                            <textarea name="course_features[${index}][description]" class="widefat" placeholder="Enter feature description"></textarea>

                            <button type="button" class="button remove-course-feature">Remove Feature</button>
                        </div>
                    `;
                container.append(newFeature);
            });

            $(document).on('click', '.remove-course-feature', function (e) {
                e.preventDefault();
                $(this).closest('.course-feature').remove();
            });
        });
    </script>
    <?php
}


// Render Financial Options Meta Box
function render_financial_options_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_financial_options', 'financial_options_nonce');

    // Retrieve existing financial options
    $financial_options = get_post_meta($post->ID, 'financial_options', true);
    $financial_options = !empty($financial_options) ? json_decode($financial_options, true) : [];
    ?>
    <div id="financial-options-container">
        <?php foreach ($financial_options as $index => $option): ?>
            <div class="financial-option">
                <hr>
                <h4>Option <?php echo $index + 1; ?></h4>
                <label for="financial_options[<?php echo $index; ?>][option]">Option:</label>
                <input type="text" name="financial_options[<?php echo $index; ?>][option]"
                    value="<?php echo esc_attr($option['option']); ?>" class="widefat" placeholder="Enter financial option">

                <label for="financial_options[<?php echo $index; ?>][description]">Description:</label>
                <textarea name="financial_options[<?php echo $index; ?>][description]" class="widefat"
                    placeholder="Enter description"><?php echo esc_textarea($option['description']); ?></textarea>

                <button type="button" class="button remove-financial-option">Remove Option</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-financial-option" class="button">Add Option</button>

    <script>
        jQuery(document).ready(function ($) {
            $('#add-financial-option').on('click', function (e) {
                e.preventDefault();
                var container = $('#financial-options-container');
                var index = container.children('.financial-option').length;
                var newOption = `
                        <div class="financial-option">
                            <hr>
                            <h4>Option ${index + 1}</h4>
                            <label for="financial_options[${index}][option]">Option:</label>
                            <input type="text" name="financial_options[${index}][option]" class="widefat" placeholder="Enter financial option">

                            <label for="financial_options[${index}][description]">Description:</label>
                            <textarea name="financial_options[${index}][description]" class="widefat" placeholder="Enter description"></textarea>

                            <button type="button" class="button remove-financial-option">Remove Option</button>
                        </div>
                    `;
                container.append(newOption);
            });

            $(document).on('click', '.remove-financial-option', function (e) {
                e.preventDefault();
                $(this).closest('.financial-option').remove();
            });
        });
    </script>
    <?php
}


// Render Mentors Meta Box
function render_mentors_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_mentors', 'mentors_nonce');

    // Retrieve existing mentors
    $mentors = get_post_meta($post->ID, 'mentors', true);
    $mentors = !empty($mentors) ? json_decode($mentors, true) : [];
    ?>
    <div id="mentors-container">
        <?php foreach ($mentors as $index => $mentor): ?>
            <div class="mentor">
                <hr>
                <h4>Mentor <?php echo $index + 1; ?></h4>
                <label for="mentors[<?php echo $index; ?>][name]">Name:</label>
                <input type="text" name="mentors[<?php echo $index; ?>][name]" value="<?php echo esc_attr($mentor['name']); ?>"
                    class="widefat" placeholder="Enter mentor name">

                <label for="mentors[<?php echo $index; ?>][position]">Position:</label>
                <input type="text" name="mentors[<?php echo $index; ?>][position]"
                    value="<?php echo esc_attr($mentor['position']); ?>" class="widefat" placeholder="Enter mentor position">

                <label for="mentors[<?php echo $index; ?>][description]">Description:</label>
                <textarea name="mentors[<?php echo $index; ?>][description]" class="widefat"
                    placeholder="Enter mentor description"><?php echo esc_textarea($mentor['description']); ?></textarea>

                <label for="mentors[<?php echo $index; ?>][image]">Image:</label>
                <div class="mentor-image">
                    <input type="hidden" class="mentor-image-url" name="mentors[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($mentor['image'] ?? ''); ?>">
                    <img class="mentor-image-preview" src="<?php echo esc_url($mentor['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($mentor['image']) ? 'block' : 'none'; ?>;">
                    <button type="button" class="button upload-mentor-image">Upload Image</button>
                    <button type="button" class="button remove-mentor-image"
                        style="display: <?php echo !empty($mentor['image']) ? 'inline-block' : 'none'; ?>;">Remove
                        Image</button>
                </div>

                <button type="button" class="button remove-mentor">Remove Mentor</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-mentor" class="button">Add Mentor</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle image upload
            function openMentorMediaUploader(button) {
                var parentDiv = button.closest('.mentor-image');
                var imageUrlField = parentDiv.find('.mentor-image-url');
                var imagePreview = parentDiv.find('.mentor-image-preview');
                var removeButton = parentDiv.find('.remove-mentor-image');

                var mediaUploader = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                }).on('select', function () {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    imageUrlField.val(attachment.url);
                    imagePreview.attr('src', attachment.url).show();
                    removeButton.show();
                }).open();
            }

            // Add Mentor Handler
            $('#add-mentor').on('click', function () {
                var container = $('#mentors-container');
                var index = container.children('.mentor').length;
                var newMentor = `
                        <div class="mentor">
                            <hr>
                            <h4>Mentor ${index + 1}</h4>
                            <label>Name:</label>
                            <input type="text" name="mentors[${index}][name]" class="widefat" placeholder="Enter mentor name">

                            <label>Position:</label>
                            <input type="text" name="mentors[${index}][position]" class="widefat" placeholder="Enter mentor position">

                            <label>Description:</label>
                            <textarea name="mentors[${index}][description]" class="widefat" placeholder="Enter mentor description"></textarea>

                            <label>Image:</label>
                            <div class="mentor-image">
                                <input type="hidden" class="mentor-image-url" name="mentors[${index}][image]" value="">
                                <img class="mentor-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;">
                                <button type="button" class="button upload-mentor-image">Upload Image</button>
                                <button type="button" class="button remove-mentor-image" style="display: none;">Remove Image</button>
                            </div>

                            <button type="button" class="button remove-mentor">Remove Mentor</button>
                        </div>
                    `;
                container.append(newMentor);
            });

            // Handle image upload for mentors
            $(document).on('click', '.upload-mentor-image', function (e) {
                e.preventDefault();
                openMentorMediaUploader($(this));
            });

            // Handle image removal for mentors
            $(document).on('click', '.remove-mentor-image', function (e) {
                e.preventDefault();
                var parentDiv = $(this).closest('.mentor-image');
                parentDiv.find('.mentor-image-url').val('');
                parentDiv.find('.mentor-image-preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Mentor Handler
            $(document).on('click', '.remove-mentor', function () {
                $(this).closest('.mentor').remove();
            });
        });
    </script>
    <?php
}


// Render Course Link Meta Box
function render_course_link_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_course_link', 'course_link_nonce');

    // Retrieve existing course link
    $course_link = get_post_meta($post->ID, 'course_link', true);
    ?>
    <label for="course_link">Course Purchase Link:</label>
    <input type="url" id="course_link" name="course_link" value="<?php echo esc_url($course_link); ?>" class="widefat"
        placeholder="https://example.com/purchase-course">
    <?php
}


// Render Course Video Link Meta Box
function render_course_video_link_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_course_video_link', 'course_video_link_nonce');

    // Retrieve existing video link
    $video_link = get_post_meta($post->ID, 'course_video_link', true);
    ?>
    <label for="course_video_link">Course Video Access Link:</label>
    <input type="url" id="course_video_link" name="course_video_link" value="<?php echo esc_url($video_link); ?>"
        class="widefat" placeholder="https://example.com/course-videos">
    <?php
}


// Add Meta Box to Link Course with WooCommerce Product
function add_course_product_meta_box()
{
    add_meta_box(
        'course_product_meta',
        'WooCommerce Product',
        'render_course_product_meta_box',
        'courses', // Replace with your CPT slug if different
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_course_product_meta_box');

function render_course_product_meta_box($post)
{
    // Add nonce for security
    wp_nonce_field('save_course_product_meta', 'course_product_meta_nonce');

    // Retrieve existing product ID if any
    $product_id = get_post_meta($post->ID, '_course_product_id', true);

    // Fetch all WooCommerce products
    $products = wc_get_products(array(
        'limit' => -1,
        'status' => 'publish',
    ));

    ?>
    <label for="course_product_select">Select WooCommerce Product:</label>
    <select name="course_product_select" id="course_product_select" class="widefat">
        <option value="">-- Select Product --</option>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo esc_attr($product->get_id()); ?>" <?php selected($product_id, $product->get_id()); ?>>
                <?php echo esc_html($product->get_name()); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}


// Save the Linked WooCommerce Product ID
function save_course_product_meta($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['course_product_meta_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['course_product_meta_nonce'], 'save_course_product_meta')) {
        return;
    }

    // Check for autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (isset($_POST['post_type']) && 'courses' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        return;
    }

    // Save or delete the product ID
    if (isset($_POST['course_product_select']) && !empty($_POST['course_product_select'])) {
        update_post_meta($post_id, '_course_product_id', sanitize_text_field($_POST['course_product_select']));
    } else {
        delete_post_meta($post_id, '_course_product_id');
    }
}
add_action('save_post', 'save_course_product_meta');


// Automatically Create WooCommerce Product When a Course is Published
function create_wc_product_on_course_publish($post_id, $post, $update)
{
    // Only proceed for 'courses' CPT
    if ($post->post_type != 'courses') {
        return;
    }

    // Prevent infinite loop
    remove_action('save_post', 'create_wc_product_on_course_publish', 10);

    // Check if not an update
    if (!$update) {
        // Create WooCommerce product
        $product = new WC_Product_Simple();
        $product->set_name($post->post_title);
        $product->set_description($post->post_content);
        $product->set_regular_price(100); // Set a default price or retrieve from course meta
        $product->set_virtual(true); // Since it's a digital product
        $product->set_downloadable(false); // Adjust if you have downloadable files
        $product->set_status('publish');
        $product_id = $product->save();

        // Save the product ID in course meta
        update_post_meta($post_id, '_course_product_id', $product_id);
    }

    // Re-add the action
    add_action('save_post', 'create_wc_product_on_course_publish', 10, 3);
}
add_action('save_post', 'create_wc_product_on_course_publish', 10, 3);


// Hook to save meta box data
add_action('save_post_courses', 'save_course_meta_boxes');

function save_course_meta_boxes($post_id)
{
    // Check if it's an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }



    /**
     * 1. Save Course Features
     */
    if (isset($_POST['course_features_nonce']) && wp_verify_nonce($_POST['course_features_nonce'], 'save_course_features')) {
        if (isset($_POST['course_features']) && is_array($_POST['course_features'])) {
            $course_features = array_map(function ($feature) {
                return array(
                    'name' => sanitize_text_field($feature['name']),
                    'description' => sanitize_textarea_field($feature['description']),
                );
            }, $_POST['course_features']);
            update_post_meta($post_id, 'course_features', json_encode($course_features));
        }
    }

    /**
     * 2. Save Financial Options
     */
    if (isset($_POST['financial_options_nonce']) && wp_verify_nonce($_POST['financial_options_nonce'], 'save_financial_options')) {
        if (isset($_POST['financial_options']) && is_array($_POST['financial_options'])) {
            $financial_options = array_map(function ($option) {
                return array(
                    'option' => sanitize_text_field($option['option']),
                    'description' => sanitize_textarea_field($option['description']),
                );
            }, $_POST['financial_options']);
            update_post_meta($post_id, 'financial_options', json_encode($financial_options));
        }
    }

    /**
     * 3. Save Mentors
     */
    if (isset($_POST['mentors_nonce']) && wp_verify_nonce($_POST['mentors_nonce'], 'save_mentors')) {
        if (isset($_POST['mentors']) && is_array($_POST['mentors'])) {
            $mentors = array_map(function ($mentor) {
                return array(
                    'name' => sanitize_text_field($mentor['name']),
                    'position' => sanitize_text_field($mentor['position']),
                    'description' => sanitize_textarea_field($mentor['description']),
                    'image' => esc_url_raw($mentor['image']),
                );
            }, $_POST['mentors']);
            update_post_meta($post_id, 'mentors', json_encode($mentors));
        }
    }

    /**
     * 4. Save Course Link
     */
    if (isset($_POST['course_link_nonce']) && wp_verify_nonce($_POST['course_link_nonce'], 'save_course_link')) {
        if (isset($_POST['course_link'])) {
            update_post_meta($post_id, 'course_link', esc_url_raw($_POST['course_link']));
        }
    }

    /**
     * 5. Save Course Video Link
     */
    if (isset($_POST['course_video_link_nonce']) && wp_verify_nonce($_POST['course_video_link_nonce'], 'save_course_video_link')) {
        if (isset($_POST['course_video_link'])) {
            update_post_meta($post_id, 'course_video_link', esc_url_raw($_POST['course_video_link']));
        }
    }
}


// Associate Purchased Course with User Account
function add_purchased_course_to_user($order_id)
{
    // Get the order
    $order = wc_get_order($order_id);

    // Get the user ID
    $user_id = $order->get_user_id();

    if (!$user_id) {
        return;
    }

    // Loop through order items
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();

        // Find the associated course CPT
        $args = array(
            'post_type' => 'courses',
            'meta_query' => array(
                array(
                    'key' => '_course_product_id',
                    'value' => $product_id,
                    'compare' => '=',
                ),
            ),
        );
        $courses = get_posts($args);

        if (!empty($courses)) {
            foreach ($courses as $course) {
                $purchased_courses = get_user_meta($user_id, '_purchased_courses', true);
                if (!is_array($purchased_courses)) {
                    $purchased_courses = array();
                }
                if (!in_array($course->ID, $purchased_courses)) {
                    $purchased_courses[] = $course->ID;
                    update_user_meta($user_id, '_purchased_courses', $purchased_courses);
                }
            }
        }
    }
}
add_action('woocommerce_order_status_completed', 'add_purchased_course_to_user');


// Shortcode to Display Purchased Courses
function display_purchased_courses()
{
    if (!is_user_logged_in()) {
        return '<p>Please log in to view your purchased courses.</p>';
    }

    $user_id = get_current_user_id();
    $purchased_courses = get_user_meta($user_id, '_purchased_courses', true);

    if (empty($purchased_courses) || !is_array($purchased_courses)) {
        return '<p>You have not purchased any courses yet.</p>';
    }

    $args = array(
        'post_type' => 'courses',
        'post__in' => $purchased_courses,
        'orderby' => 'post__in',
    );

    $courses = get_posts($args);

    if (empty($courses)) {
        return '<p>You have not purchased any courses yet.</p>';
    }

    ob_start(); ?>

    <div class="purchased-courses-container">
        <h2>Your Purchased Courses</h2>
        <ul class="purchased-courses-list">
            <?php foreach ($courses as $course): ?>
                <li class="purchased-course-item">
                    <a href="<?php echo get_permalink($course->ID); ?>">
                        <?php echo get_the_title($course->ID); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('purchased_courses', 'display_purchased_courses');


// Redirect Non-Logged-In Users from Product Pages
function restrict_product_page_to_logged_in_users()
{
    if (is_product()) {
        if (!is_user_logged_in()) {
            // Redirect to login page with redirect back to the product page after login
            wp_redirect(wp_login_url(get_permalink()));
            exit;
        }
    }
}
add_action('template_redirect', 'restrict_product_page_to_logged_in_users');


// Hide WooCommerce Products from Non-Logged-In Users
function hide_courses_products_from_guests($query)
{
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
        if (!is_user_logged_in()) {
            // Exclude all products by setting a non-existing taxonomy term
            $tax_query = (array) $query->get('tax_query');

            $tax_query[] = array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            );

            $query->set('tax_query', $tax_query);
            // Optionally, display a message or redirect
        }
    }
}
add_action('pre_get_posts', 'hide_courses_products_from_guests');

?>