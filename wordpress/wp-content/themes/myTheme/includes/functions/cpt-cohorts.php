<?php
/**
 * Plugin Name: Custom Co-horts CPT with Cohort Link and Testimonials
 * Description: Registers the Co-horts Custom Post Type and adds a Cohort Link field along with a Testimonials meta box for adding testimonials.
 * Version: 1.0
 * Author: Your Name
 * Text Domain: custom-cohorts
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Register Co-horts Custom Post Type
 */
function register_cpt_cohorts()
{
    $labels = array(
        'name' => 'Co-horts',
        'singular_name' => 'Co-hort',
        'menu_name' => 'Co-horts',
        'name_admin_bar' => 'Co-hort',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Co-hort',
        'new_item' => 'New Co-hort',
        'edit_item' => 'Edit Co-hort',
        'view_item' => 'View Co-hort',
        'all_items' => 'All Co-horts',
        'search_items' => 'Search Co-horts',
        'parent_item_colon' => 'Parent Co-horts:',
        'not_found' => 'No co-horts found.',
        'not_found_in_trash' => 'No co-horts found in Trash.',
        'featured_image' => 'Co-hort Image',
        'set_featured_image' => 'Set co-hort image',
        'remove_featured_image' => 'Remove co-hort image',
        'use_featured_image' => 'Use as co-hort image',
        'archives' => 'Co-hort archives',
        'insert_into_item' => 'Insert into co-hort',
        'uploaded_to_this_item' => 'Uploaded to this co-hort',
        'filter_items_list' => 'Filter co-horts list',
        'items_list_navigation' => 'Co-horts list navigation',
        'items_list' => 'Co-horts list',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'co_horts'),
        'show_in_rest' => true, // Enable Gutenberg editor
        'menu_icon' => 'dashicons-groups', // Dashboard icon
        'capability_type' => 'post',
        'hierarchical' => false,
    );

    register_post_type('co_horts', $args);
}
add_action('init', 'register_cpt_cohorts');

/**
 * 2. Add Cohort Link Meta Box for Co-horts
 */
function add_cohorts_meta_boxes()
{
    // Cohort Link Meta Box
    add_meta_box(
        'cohorts_cohort_link',
        'Cohort Link',
        'render_cohorts_cohort_link_meta_box',
        'co_horts',
        'normal',
        'high'
    );

    // Testimonials Meta Box
    add_meta_box(
        'cohorts_testimonials',
        'Testimonials',
        'render_cohorts_testimonials_meta_box',
        'co_horts',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_cohorts_meta_boxes');

/**
 * 3. Render Cohort Link Meta Box
 */
function render_cohorts_cohort_link_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_cohorts_cohort_link', 'cohorts_cohort_link_nonce');

    // Retrieve existing cohort link
    $cohort_link = get_post_meta($post->ID, 'cohorts_cohort_link', true);
    ?>
    <p>
        <label for="cohorts_cohort_link">Cohort Link:</label><br>
        <input type="url" id="cohorts_cohort_link" name="cohorts_cohort_link" value="<?php echo esc_url($cohort_link); ?>"
            placeholder="https://example.com" class="widefat">
    </p>
    <?php
}

/**
 * 4. Render Testimonials Meta Box
 */
function render_cohorts_testimonials_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_cohorts_testimonials', 'cohorts_testimonials_nonce');

    // Retrieve existing testimonials
    $testimonials = get_post_meta($post->ID, 'cohorts_testimonials', true);
    $testimonials = !empty($testimonials) ? json_decode($testimonials, true) : [];
    ?>
    <div id="cohorts_testimonials_container">
        <?php foreach ($testimonials as $index => $testimonial): ?>
            <div class="cohort_testimonial">
                <hr>
                <h4>Testimonial <?php echo $index + 1; ?></h4>
                <p>
                    <label for="cohorts_testimonials[<?php echo $index; ?>][name]">Name:</label><br>
                    <input type="text" name="cohorts_testimonials[<?php echo $index; ?>][name]"
                        value="<?php echo esc_attr($testimonial['name']); ?>" placeholder="Enter name" class="widefat" required>
                </p>
                <p>
                    <label for="cohorts_testimonials[<?php echo $index; ?>][text]">Testimonial:</label><br>
                    <textarea name="cohorts_testimonials[<?php echo $index; ?>][text]" placeholder="Enter testimonial"
                        class="widefat" required><?php echo esc_textarea($testimonial['text']); ?></textarea>
                </p>

                <!-- Image Upload Field -->
                <div class="testimonial_image_upload">
                    <label>Image:</label><br>
                    <input type="hidden" class="testimonial_image_url" name="cohorts_testimonials[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($testimonial['image'] ?? ''); ?>">
                    <img class="testimonial_image_preview" src="<?php echo esc_url($testimonial['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($testimonial['image']) ? 'block' : 'none'; ?>;"><br>
                    <button type="button" class="button upload_testimonial_image">Upload Image</button>
                    <button type="button" class="button remove_testimonial_image"
                        style="display: <?php echo !empty($testimonial['image']) ? 'inline-block' : 'none'; ?>;">Remove
                        Image</button>
                </div>

                <button type="button" class="button remove_testimonial">Remove Testimonial</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add_testimonial" class="button">Add Testimonial</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle image upload
            function openTestimonialMediaUploader(e) {
                e.preventDefault();

                var button = $(this);
                var container = button.closest('.testimonial_image_upload');
                var imageUrlInput = container.find('.testimonial_image_url');
                var imagePreview = container.find('.testimonial_image_preview');
                var removeButton = container.find('.remove_testimonial_image');

                var mediaUploader = wp.media({
                    title: 'Choose Testimonial Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                })
                    .on('select', function () {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        imageUrlInput.val(attachment.url);
                        imagePreview.attr('src', attachment.url).show();
                        removeButton.show();
                    })
                    .open();
            }

            // Add Testimonial Handler
            $('#add_testimonial').on('click', function () {
                var container = $('#cohorts_testimonials_container');
                var index = container.children('.cohort_testimonial').length;

                var newTestimonial = `
                        <div class="cohort_testimonial">
                            <hr>
                            <h4>Testimonial ${index + 1}</h4>
                            <p>
                                <label for="cohorts_testimonials[${index}][name]">Name:</label><br>
                                <input type="text" name="cohorts_testimonials[${index}][name]" placeholder="Enter name" class="widefat" required>
                            </p>
                            <p>
                                <label for="cohorts_testimonials[${index}][text]">Testimonial:</label><br>
                                <textarea name="cohorts_testimonials[${index}][text]" placeholder="Enter testimonial" class="widefat" required></textarea>
                            </p>

                            <!-- Image Upload Field -->
                            <div class="testimonial_image_upload">
                                <label>Image:</label><br>
                                <input type="hidden" class="testimonial_image_url" name="cohorts_testimonials[${index}][image]" value="">
                                <img class="testimonial_image_preview" src="" style="max-width: 100px; max-height: 100px; display: none;"><br>
                                <button type="button" class="button upload_testimonial_image">Upload Image</button>
                                <button type="button" class="button remove_testimonial_image" style="display: none;">Remove Image</button>
                            </div>

                            <button type="button" class="button remove_testimonial">Remove Testimonial</button>
                        </div>
                    `;
                container.append(newTestimonial);
            });

            // Handle Image Upload for Testimonials
            $(document).on('click', '.upload_testimonial_image', openTestimonialMediaUploader);

            // Handle Image Removal for Testimonials
            $(document).on('click', '.remove_testimonial_image', function (e) {
                e.preventDefault();
                var container = $(this).closest('.testimonial_image_upload');
                container.find('.testimonial_image_url').val('');
                container.find('.testimonial_image_preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Testimonial Handler
            $(document).on('click', '.remove_testimonial', function () {
                $(this).closest('.cohort_testimonial').remove();
            });
        });
    </script>
    <?php
}

/**
 * 5. Save Meta Box Data
 */
function save_cohorts_meta_boxes($post_id)
{
    // Check if our nonces are set.
    if (
        !isset($_POST['cohorts_cohort_link_nonce']) ||
        !isset($_POST['cohorts_testimonials_nonce'])
    ) {
        return;
    }

    // Verify that the nonces are valid.
    if (
        !wp_verify_nonce($_POST['cohorts_cohort_link_nonce'], 'save_cohorts_cohort_link') ||
        !wp_verify_nonce($_POST['cohorts_testimonials_nonce'], 'save_cohorts_testimonials')
    ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (isset($_POST['post_type']) && 'co_horts' == $_POST['post_type']) {
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
    } else {
        return;
    }

    /**
     * 1. Save Cohort Link
     */
    if (isset($_POST['cohorts_cohort_link'])) {
        $cohort_link = sanitize_url($_POST['cohorts_cohort_link']);
        update_post_meta($post_id, 'cohorts_cohort_link', $cohort_link);
    }

    /**
     * 2. Save Testimonials
     */
    if (isset($_POST['cohorts_testimonials']) && is_array($_POST['cohorts_testimonials'])) {
        $testimonials = array_map(function ($testimonial) {
            return array(
                'name' => sanitize_text_field($testimonial['name']),
                'text' => sanitize_textarea_field($testimonial['text']),
                'image' => esc_url_raw($testimonial['image']),
            );
        }, $_POST['cohorts_testimonials']);

        // Remove any testimonials without a name or image
        $testimonials = array_filter($testimonials, function ($testimonial) {
            return !empty($testimonial['name']) && !empty($testimonial['image']);
        });

        // Reindex array to prevent gaps
        $testimonials = array_values($testimonials);

        // Update post meta
        update_post_meta($post_id, 'cohorts_testimonials', json_encode($testimonials));
    } else {
        // If no testimonials are set, delete the meta
        delete_post_meta($post_id, 'cohorts_testimonials');
    }
}
add_action('save_post_co_horts', 'save_cohorts_meta_boxes');

/**
 * 6. Enqueue Scripts for Media Uploader and Dynamic Fields
 */
function enqueue_cohorts_meta_box_scripts($hook)
{
    // Only enqueue scripts on the co_horts edit screens
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    global $post;
    if ($post->post_type !== 'co_horts') {
        return;
    }

    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Enqueue jQuery (already included in WordPress by default)
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'enqueue_cohorts_meta_box_scripts');
