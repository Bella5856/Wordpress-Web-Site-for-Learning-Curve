<?php
/**
 * Plugin Name: Custom Guides CPT and Featured Brands, Mentors, Learning Points
 * Description: Registers the Guides Custom Post Type and adds meta boxes for Featured Brands, Mentors, and What Will You Learn sections.
 * Version: 1.1
 * Author: Your Name
 * Text Domain: custom-guides
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Register Guides Custom Post Type
 */
function register_cpt_guides()
{
    $labels = array(
        'name' => 'Guides',
        'singular_name' => 'Guide',
        'menu_name' => 'Guides',
        'name_admin_bar' => 'Guide',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Guide',
        'new_item' => 'New Guide',
        'edit_item' => 'Edit Guide',
        'view_item' => 'View Guide',
        'all_items' => 'All Guides',
        'search_items' => 'Search Guides',
        'parent_item_colon' => 'Parent Guides:',
        'not_found' => 'No guides found.',
        'not_found_in_trash' => 'No guides found in Trash.',
        'featured_image' => 'Guide Image',
        'set_featured_image' => 'Set guide image',
        'remove_featured_image' => 'Remove guide image',
        'use_featured_image' => 'Use as guide image',
        'archives' => 'Guide archives',
        'insert_into_item' => 'Insert into guide',
        'uploaded_to_this_item' => 'Uploaded to this guide',
        'filter_items_list' => 'Filter guides list',
        'items_list_navigation' => 'Guides list navigation',
        'items_list' => 'Guides list',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'guides'),
        'show_in_rest' => true, // Enable Gutenberg editor
        'menu_icon' => 'dashicons-welcome-learn-more', // Dashboard icon
        'capability_type' => 'post',
        'hierarchical' => false,
    );

    register_post_type('guides', $args);
}
add_action('init', 'register_cpt_guides');

/**
 * 2. Add Meta Boxes for Guides
 */
function add_guide_meta_boxes()
{
    // Featured Brands Meta Box
    add_meta_box(
        'guide_featured_brands',
        'Featured Brands',
        'render_guide_featured_brands_meta_box',
        'guides',
        'normal',
        'high'
    );

    // Mentors Meta Box
    add_meta_box(
        'guide_mentors',
        'Mentors',
        'render_guide_mentors_meta_box',
        'guides',
        'normal',
        'high'
    );

    // What Will You Learn Meta Box
    add_meta_box(
        'guide_learning_points',
        'What Will You Learn',
        'render_guide_learning_points_meta_box',
        'guides',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_guide_meta_boxes');

/**
 * 3. Render Featured Brands Meta Box
 */
function render_guide_featured_brands_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_guide_featured_brands', 'guide_featured_brands_nonce');

    // Retrieve existing featured brands
    $featured_brands = get_post_meta($post->ID, 'guide_featured_brands', true);
    $featured_brands = !empty($featured_brands) ? json_decode($featured_brands, true) : [];
    ?>
    <div id="featured-brands-container">
        <?php foreach ($featured_brands as $index => $brand): ?>
            <div class="featured-brand">
                <hr>
                <h4>Brand <?php echo $index + 1; ?></h4>
                <!-- Image Upload Field -->
                <div class="brand-image">
                    <label>Logo:</label><br>
                    <input type="hidden" class="brand-image-url" name="guide_featured_brands[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($brand['image'] ?? ''); ?>">
                    <img class="brand-image-preview" src="<?php echo esc_url($brand['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($brand['image']) ? 'block' : 'none'; ?>;"><br>
                    <button type="button" class="button upload-brand-image">Upload Logo</button>
                    <button type="button" class="button remove-brand-image"
                        style="display: <?php echo !empty($brand['image']) ? 'inline-block' : 'none'; ?>;">Remove Logo</button>
                </div>

                <button type="button" class="button remove-brand">Remove Brand</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-brand" class="button">Add Brand</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle image upload
            function openMediaUploader(e) {
                e.preventDefault();

                const button = $(this);
                const parentDiv = button.closest('.brand-image');
                const imageUrlField = parentDiv.find('.brand-image-url');
                const imagePreview = parentDiv.find('.brand-image-preview');
                const removeButton = parentDiv.find('.remove-brand-image');

                const mediaUploader = wp.media({
                    title: 'Choose Logo',
                    button: {
                        text: 'Use this logo'
                    },
                    multiple: false
                }).on('select', function () {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    imageUrlField.val(attachment.url);
                    imagePreview.attr('src', attachment.url).show();
                    removeButton.show();
                }).open();
            }

            // Add Brand Handler
            $('#add-brand').on('click', function () {
                const container = $('#featured-brands-container');
                const index = container.children('.featured-brand').length;

                const newBrand = `
                            <div class="featured-brand">
                                <hr>
                                <h4>Brand ${index + 1}</h4>
                                <!-- Image Upload Field -->
                                <div class="brand-image">
                                    <label>Logo:</label><br>
                                    <input type="hidden" class="brand-image-url" name="guide_featured_brands[${index}][image]" value="">
                                    <img class="brand-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;"><br>
                                    <button type="button" class="button upload-brand-image">Upload Logo</button>
                                    <button type="button" class="button remove-brand-image" style="display: none;">Remove Logo</button>
                                </div>

                                <button type="button" class="button remove-brand">Remove Brand</button>
                            </div>
                        `;
                container.append(newBrand);
            });

            // Handle Image Upload for Brands
            $(document).on('click', '.upload-brand-image', openMediaUploader);

            // Handle Image Removal for Brands
            $(document).on('click', '.remove-brand-image', function (e) {
                e.preventDefault();
                const parentDiv = $(this).closest('.brand-image');
                parentDiv.find('.brand-image-url').val('');
                parentDiv.find('.brand-image-preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Brand Handler
            $(document).on('click', '.remove-brand', function () {
                $(this).closest('.featured-brand').remove();
                // Optionally, you can re-index the remaining brands here
            });
        });
    </script>
    <?php
}

/**
 * 4. Render Mentors Meta Box
 */
function render_guide_mentors_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_guide_mentors', 'guide_mentors_nonce');

    // Retrieve existing mentors
    $mentors = get_post_meta($post->ID, '_guide_mentors', true);
    $mentors = !empty($mentors) ? json_decode($mentors, true) : [];
    ?>
    <div id="mentors-container">
        <?php foreach ($mentors as $index => $mentor): ?>
            <div class="mentor">
                <hr>
                <h4>Mentor <?php echo $index + 1; ?></h4>
                <!-- Image Upload Field -->
                <div class="mentor-image">
                    <label>Image:</label><br>
                    <input type="hidden" class="mentor-image-url" name="guide_mentors[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($mentor['image'] ?? ''); ?>">
                    <img class="mentor-image-preview" src="<?php echo esc_url($mentor['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($mentor['image']) ? 'block' : 'none'; ?>;"><br>
                    <button type="button" class="button upload-mentor-image">Upload Image</button>
                    <button type="button" class="button remove-mentor-image"
                        style="display: <?php echo !empty($mentor['image']) ? 'inline-block' : 'none'; ?>;">Remove
                        Image</button>
                </div>

                <p>
                    <label>Name:</label><br>
                    <input type="text" name="guide_mentors[<?php echo $index; ?>][name]"
                        value="<?php echo esc_attr($mentor['name'] ?? ''); ?>" placeholder="Enter mentor name" class="widefat">
                </p>
                <p>
                    <label>Title:</label><br>
                    <input type="text" name="guide_mentors[<?php echo $index; ?>][title]"
                        value="<?php echo esc_attr($mentor['title'] ?? ''); ?>" placeholder="Enter mentor title"
                        class="widefat">
                </p>
                <p>
                    <label>Description:</label><br>
                    <textarea name="guide_mentors[<?php echo $index; ?>][description]" placeholder="Enter mentor description"
                        class="widefat"><?php echo esc_textarea($mentor['description'] ?? ''); ?></textarea>
                </p>

                <button type="button" class="button remove-mentor">Remove Mentor</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-mentor" class="button">Add Mentor</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle mentor image upload
            function openMentorMediaUploader(e) {
                e.preventDefault();

                const button = $(this);
                const parentDiv = button.closest('.mentor-image');
                const imageUrlField = parentDiv.find('.mentor-image-url');
                const imagePreview = parentDiv.find('.mentor-image-preview');
                const removeButton = parentDiv.find('.remove-mentor-image');

                const mediaUploader = wp.media({
                    title: 'Choose Mentor Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                }).on('select', function () {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    imageUrlField.val(attachment.url);
                    imagePreview.attr('src', attachment.url).show();
                    removeButton.show();
                }).open();
            }

            // Add Mentor Handler
            $('#add-mentor').on('click', function () {
                const container = $('#mentors-container');
                const index = container.children('.mentor').length;

                const newMentor = `
                            <div class="mentor">
                                <hr>
                                <h4>Mentor ${index + 1}</h4>
                                <!-- Image Upload Field -->
                                <div class="mentor-image">
                                    <label>Image:</label><br>
                                    <input type="hidden" class="mentor-image-url" name="guide_mentors[${index}][image]" value="">
                                    <img class="mentor-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;"><br>
                                    <button type="button" class="button upload-mentor-image">Upload Image</button>
                                    <button type="button" class="button remove-mentor-image" style="display: none;">Remove Image</button>
                                </div>

                                <p>
                                    <label>Name:</label><br>
                                    <input type="text" name="guide_mentors[${index}][name]" placeholder="Enter mentor name" class="widefat">
                                </p>
                                <p>
                                    <label>Title:</label><br>
                                    <input type="text" name="guide_mentors[${index}][title]" placeholder="Enter mentor title" class="widefat">
                                </p>
                                <p>
                                    <label>Description:</label><br>
                                    <textarea name="guide_mentors[${index}][description]" placeholder="Enter mentor description" class="widefat"></textarea>
                                </p>

                                <button type="button" class="button remove-mentor">Remove Mentor</button>
                            </div>
                        `;
                container.append(newMentor);
            });

            // Handle Image Upload for Mentors
            $(document).on('click', '.upload-mentor-image', openMentorMediaUploader);

            // Handle Image Removal for Mentors
            $(document).on('click', '.remove-mentor-image', function (e) {
                e.preventDefault();
                const parentDiv = $(this).closest('.mentor-image');
                parentDiv.find('.mentor-image-url').val('');
                parentDiv.find('.mentor-image-preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Mentor Handler
            $(document).on('click', '.remove-mentor', function () {
                $(this).closest('.mentor').remove();
                // Optionally, re-index remaining mentors here
            });
        });
    </script>
    <?php
}

/**
 * 5. Render What Will You Learn Meta Box
 */
function render_guide_learning_points_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_guide_learning_points', 'guide_learning_points_nonce');

    // Retrieve existing learning points
    $learning_points = get_post_meta($post->ID, '_guide_learning_points', true);
    $learning_points = !empty($learning_points) ? json_decode($learning_points, true) : [];
    ?>
    <div id="learning-points-container">
        <?php foreach ($learning_points as $index => $point): ?>
            <div class="learning-point">
                <hr>
                <h4>Learning Point <?php echo $index + 1; ?></h4>
                <!-- Image Upload Field -->
                <div class="learning-point-image">
                    <label>Image:</label><br>
                    <input type="hidden" class="learning-point-image-url"
                        name="guide_learning_points[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($point['image'] ?? ''); ?>">
                    <img class="learning-point-image-preview" src="<?php echo esc_url($point['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($point['image']) ? 'block' : 'none'; ?>;"><br>
                    <button type="button" class="button upload-learning-point-image">Upload Image</button>
                    <button type="button" class="button remove-learning-point-image"
                        style="display: <?php echo !empty($point['image']) ? 'inline-block' : 'none'; ?>;">Remove Image</button>
                </div>

                <p>
                    <label>Title:</label><br>
                    <input type="text" name="guide_learning_points[<?php echo $index; ?>][title]"
                        value="<?php echo esc_attr($point['title'] ?? ''); ?>" placeholder="Enter learning point title"
                        class="widefat">
                </p>
                <p>
                    <label>Description:</label><br>
                    <textarea name="guide_learning_points[<?php echo $index; ?>][description]"
                        placeholder="Enter learning point description"
                        class="widefat"><?php echo esc_textarea($point['description'] ?? ''); ?></textarea>
                </p>

                <button type="button" class="button remove-learning-point">Remove Learning Point</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-learning-point" class="button">Add Learning Point</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle learning point image upload
            function openLearningPointMediaUploader(e) {
                e.preventDefault();

                const button = $(this);
                const parentDiv = button.closest('.learning-point-image');
                const imageUrlField = parentDiv.find('.learning-point-image-url');
                const imagePreview = parentDiv.find('.learning-point-image-preview');
                const removeButton = parentDiv.find('.remove-learning-point-image');

                const mediaUploader = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                }).on('select', function () {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    imageUrlField.val(attachment.url);
                    imagePreview.attr('src', attachment.url).show();
                    removeButton.show();
                }).open();
            }

            // Add Learning Point Handler
            $('#add-learning-point').on('click', function () {
                const container = $('#learning-points-container');
                const index = container.children('.learning-point').length;

                const newPoint = `
                            <div class="learning-point">
                                <hr>
                                <h4>Learning Point ${index + 1}</h4>
                                <!-- Image Upload Field -->
                                <div class="learning-point-image">
                                    <label>Image:</label><br>
                                    <input type="hidden" class="learning-point-image-url" name="guide_learning_points[${index}][image]" value="">
                                    <img class="learning-point-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;"><br>
                                    <button type="button" class="button upload-learning-point-image">Upload Image</button>
                                    <button type="button" class="button remove-learning-point-image" style="display: none;">Remove Image</button>
                                </div>

                                <p>
                                    <label>Title:</label><br>
                                    <input type="text" name="guide_learning_points[${index}][title]" placeholder="Enter learning point title" class="widefat">
                                </p>
                                <p>
                                    <label>Description:</label><br>
                                    <textarea name="guide_learning_points[${index}][description]" placeholder="Enter learning point description" class="widefat"></textarea>
                                </p>

                                <button type="button" class="button remove-learning-point">Remove Learning Point</button>
                            </div>
                        `;
                container.append(newPoint);
            });

            // Handle Image Upload for Learning Points
            $(document).on('click', '.upload-learning-point-image', openLearningPointMediaUploader);

            // Handle Image Removal for Learning Points
            $(document).on('click', '.remove-learning-point-image', function (e) {
                e.preventDefault();
                const parentDiv = $(this).closest('.learning-point-image');
                parentDiv.find('.learning-point-image-url').val('');
                parentDiv.find('.learning-point-image-preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Learning Point Handler
            $(document).on('click', '.remove-learning-point', function () {
                $(this).closest('.learning-point').remove();
                // Optionally, re-index remaining learning points here
            });
        });
    </script>
    <?php
}

/**
 * 6. Save Meta Box Data
 */
function save_guide_meta_boxes($post_id)
{
    // Check if our nonces are set.
    if (
        !isset($_POST['guide_featured_brands_nonce']) ||
        !isset($_POST['guide_mentors_nonce']) ||
        !isset($_POST['guide_learning_points_nonce'])
    ) {
        return;
    }

    // Verify that the nonces are valid.
    if (
        !wp_verify_nonce($_POST['guide_featured_brands_nonce'], 'save_guide_featured_brands') ||
        !wp_verify_nonce($_POST['guide_mentors_nonce'], 'save_guide_mentors') ||
        !wp_verify_nonce($_POST['guide_learning_points_nonce'], 'save_guide_learning_points')
    ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    /**
     * 1. Save Featured Brands
     */
    if (isset($_POST['guide_featured_brands']) && is_array($_POST['guide_featured_brands'])) {
        $featured_brands = array_map(function ($brand) {
            return array(
                'image' => esc_url_raw($brand['image']),
            );
        }, $_POST['guide_featured_brands']);

        // Remove any empty entries
        $featured_brands = array_filter($featured_brands, function ($brand) {
            return !empty($brand['image']);
        });

        update_post_meta($post_id, 'guide_featured_brands', json_encode($featured_brands));
    } else {
        // If no brands are set, delete the meta
        delete_post_meta($post_id, 'guide_featured_brands');
    }

    /**
     * 2. Save Mentors
     */
    if (isset($_POST['guide_mentors']) && is_array($_POST['guide_mentors'])) {
        $mentors = array_map(function ($mentor) {
            return array(
                'image' => esc_url_raw($mentor['image']),
                'name' => sanitize_text_field($mentor['name']),
                'title' => sanitize_text_field($mentor['title']),
                'description' => sanitize_textarea_field($mentor['description']),
            );
        }, $_POST['guide_mentors']);

        // Remove any empty entries (e.g., mentors without a name)
        $mentors = array_filter($mentors, function ($mentor) {
            return !empty($mentor['name']) && !empty($mentor['image']);
        });

        update_post_meta($post_id, '_guide_mentors', json_encode($mentors));
    } else {
        // If no mentors are set, delete the meta
        delete_post_meta($post_id, '_guide_mentors');
    }

    /**
     * 3. Save What Will You Learn
     */
    if (isset($_POST['guide_learning_points']) && is_array($_POST['guide_learning_points'])) {
        $learning_points = array_map(function ($point) {
            return array(
                'image' => esc_url_raw($point['image']),
                'title' => sanitize_text_field($point['title']),
                'description' => sanitize_textarea_field($point['description']),
            );
        }, $_POST['guide_learning_points']);

        // Remove any empty entries
        $learning_points = array_filter($learning_points, function ($point) {
            return !empty($point['title']) && !empty($point['image']);
        });

        update_post_meta($post_id, '_guide_learning_points', json_encode($learning_points));
    } else {
        // If no learning points are set, delete the meta
        delete_post_meta($post_id, '_guide_learning_points');
    }
}
add_action('save_post_guides', 'save_guide_meta_boxes');

/**
 * 7. Enqueue Scripts for Media Uploader
 */
function enqueue_guide_meta_box_scripts($hook)
{
    // Only enqueue scripts on the Guides edit screen
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    global $post;
    if ($post->post_type !== 'guides') {
        return;
    }

    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Enqueue jQuery (already included in WordPress by default)
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'enqueue_guide_meta_box_scripts');
?>