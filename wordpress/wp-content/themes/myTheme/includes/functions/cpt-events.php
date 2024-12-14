<?php
/**
 * Plugin Name: Custom Events CPT and Meta Boxes
 * Description: Registers the Events Custom Post Type and adds meta boxes for event details, speakers, testimonials, and top brands.
 * Version: 1.0
 * Author: Your Name
 * Text Domain: custom-events
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Register Events Custom Post Type
 */
function register_cpt_events()
{
    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'menu_name' => 'Events',
        'name_admin_bar' => 'Event',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Event',
        'new_item' => 'New Event',
        'edit_item' => 'Edit Event',
        'view_item' => 'View Event',
        'all_items' => 'All Events',
        'search_items' => 'Search Events',
        'parent_item_colon' => 'Parent Events:',
        'not_found' => 'No events found.',
        'not_found_in_trash' => 'No events found in Trash.',
        'featured_image' => 'Event Image',
        'set_featured_image' => 'Set event image',
        'remove_featured_image' => 'Remove event image',
        'use_featured_image' => 'Use as event image',
        'archives' => 'Event archives',
        'insert_into_item' => 'Insert into event',
        'uploaded_to_this_item' => 'Uploaded to this event',
        'filter_items_list' => 'Filter events list',
        'items_list_navigation' => 'Events list navigation',
        'items_list' => 'Events list',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'events'),
        'show_in_rest' => true, // Enable Gutenberg editor
        'menu_icon' => 'dashicons-calendar-alt', // Dashboard icon
        'capability_type' => 'post',
        'hierarchical' => false,
    );

    register_post_type('events', $args);
}
add_action('init', 'register_cpt_events');

/**
 * 2. Add Meta Boxes for Events
 */
function add_event_meta_boxes()
{
    // Event Details Meta Box
    add_meta_box(
        'event_details',
        'Event Details',
        'render_event_details_meta_box',
        'events',
        'normal',
        'high'
    );

    // Speakers Meta Box
    add_meta_box(
        'event_speakers',
        'Event Speakers',
        'render_event_speakers_meta_box',
        'events',
        'normal',
        'high'
    );

    // Testimonials Meta Box
    add_meta_box(
        'event_testimonials',
        'Event Testimonials',
        'render_event_testimonials_meta_box',
        'events',
        'normal',
        'high'
    );

    // Top Brands Meta Box
    add_meta_box(
        'event_top_brands',
        'Top Brands',
        'render_event_top_brands_meta_box',
        'events',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

/**
 * 3. Render Event Details Meta Box
 */
function render_event_details_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_event_details', 'event_details_nonce');

    // Retrieve existing values
    $from_date = get_post_meta($post->ID, 'event_from_date', true);
    $to_date = get_post_meta($post->ID, 'event_to_date', true);
    $event_time = get_post_meta($post->ID, 'event_time', true);
    $event_place = get_post_meta($post->ID, 'event_place', true);
    $event_link = get_post_meta($post->ID, 'event_link', true);
    ?>
    <p>
        <label for="event_from_date">From Date:</label><br>
        <input type="date" id="event_from_date" name="event_from_date" value="<?php echo esc_attr($from_date); ?>"
            class="widefat">
    </p>
    <p>
        <label for="event_to_date">To Date:</label><br>
        <input type="date" id="event_to_date" name="event_to_date" value="<?php echo esc_attr($to_date); ?>"
            class="widefat">
    </p>
    <p>
        <label for="event_time">Time:</label><br>
        <input type="text" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>"
            placeholder="e.g., 2:00 PM" class="widefat">
    </p>
    <p>
        <label for="event_place">Place:</label><br>
        <input type="text" id="event_place" name="event_place" value="<?php echo esc_attr($event_place); ?>"
            placeholder="Event location" class="widefat">
    </p>
    <p>
        <label for="event_link">Event Link:</label><br>
        <input type="url" id="event_link" name="event_link" value="<?php echo esc_url($event_link); ?>"
            placeholder="https://example.com" class="widefat">
    </p>
    <?php
}

/**
 * 4. Render Speakers Meta Box
 */
function render_event_speakers_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_event_speakers', 'event_speakers_nonce');

    // Retrieve existing speakers
    $speakers = get_post_meta($post->ID, 'event_speakers', true);
    $speakers = !empty($speakers) ? json_decode($speakers, true) : [];
    ?>
    <div id="speakers-container">
        <?php foreach ($speakers as $index => $speaker): ?>
            <div class="speaker">
                <hr>
                <h4>Speaker <?php echo $index + 1; ?></h4>
                <p>
                    <label for="speakers[<?php echo $index; ?>][name]">Name:</label><br>
                    <input type="text" name="speakers[<?php echo $index; ?>][name]"
                        value="<?php echo esc_attr($speaker['name']); ?>" placeholder="Enter speaker name" class="widefat"
                        required>
                </p>
                <p>
                    <label for="speakers[<?php echo $index; ?>][position]">Position:</label><br>
                    <input type="text" name="speakers[<?php echo $index; ?>][position]"
                        value="<?php echo esc_attr($speaker['position']); ?>" placeholder="Enter speaker position"
                        class="widefat">
                </p>
                <p>
                    <label for="speakers[<?php echo $index; ?>][text]">Description:</label><br>
                    <textarea name="speakers[<?php echo $index; ?>][text]" placeholder="Enter speaker description"
                        class="widefat"><?php echo esc_textarea($speaker['text']); ?></textarea>
                </p>

                <!-- Image Upload Field -->
                <div class="speaker-image">
                    <label>Image:</label><br>
                    <input type="hidden" class="speaker-image-url" name="speakers[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($speaker['image'] ?? ''); ?>">
                    <img class="speaker-image-preview" src="<?php echo esc_url($speaker['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($speaker['image']) ? 'block' : 'none'; ?>;"><br>
                    <button type="button" class="button upload-speaker-image">Upload Image</button>
                    <button type="button" class="button remove-speaker-image"
                        style="display: <?php echo !empty($speaker['image']) ? 'inline-block' : 'none'; ?>;">Remove
                        Image</button>
                </div>

                <button type="button" class="button remove-speaker">Remove Speaker</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-speaker" class="button">Add Speaker</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle image upload
            function openMediaUploader(e) {
                e.preventDefault();

                const button = $(this);
                const parentDiv = button.closest('.speaker-image');
                const imageUrlField = parentDiv.find('.speaker-image-url');
                const imagePreview = parentDiv.find('.speaker-image-preview');
                const removeButton = parentDiv.find('.remove-speaker-image');

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

            // Add Speaker Handler
            $('#add-speaker').on('click', function () {
                const container = $('#speakers-container');
                const index = container.children('.speaker').length;

                const newSpeaker = `
                        <div class="speaker">
                            <hr>
                            <h4>Speaker ${index + 1}</h4>
                            <p>
                                <label for="speakers[${index}][name]">Name:</label><br>
                                <input type="text" name="speakers[${index}][name]" placeholder="Enter speaker name" class="widefat" required>
                            </p>
                            <p>
                                <label for="speakers[${index}][position]">Position:</label><br>
                                <input type="text" name="speakers[${index}][position]" placeholder="Enter speaker position" class="widefat">
                            </p>
                            <p>
                                <label for="speakers[${index}][text]">Description:</label><br>
                                <textarea name="speakers[${index}][text]" placeholder="Enter speaker description" class="widefat"></textarea>
                            </p>

                            <!-- Image Upload Field -->
                            <div class="speaker-image">
                                <label>Image:</label><br>
                                <input type="hidden" class="speaker-image-url" name="speakers[${index}][image]" value="">
                                <img class="speaker-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;"><br>
                                <button type="button" class="button upload-speaker-image">Upload Image</button>
                                <button type="button" class="button remove-speaker-image" style="display: none;">Remove Image</button>
                            </div>

                            <button type="button" class="button remove-speaker">Remove Speaker</button>
                        </div>
                    `;
                container.append(newSpeaker);
            });

            // Handle Image Upload for Speakers
            $(document).on('click', '.upload-speaker-image', openMediaUploader);

            // Handle Image Removal for Speakers
            $(document).on('click', '.remove-speaker-image', function (e) {
                e.preventDefault();
                const parentDiv = $(this).closest('.speaker-image');
                parentDiv.find('.speaker-image-url').val('');
                parentDiv.find('.speaker-image-preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Speaker Handler
            $(document).on('click', '.remove-speaker', function () {
                $(this).closest('.speaker').remove();
            });
        });
    </script>
    <?php
}

/**
 * 5. Render Testimonials Meta Box
 */
function render_event_testimonials_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_event_testimonials', 'event_testimonials_nonce');

    // Retrieve existing testimonials
    $testimonials = get_post_meta($post->ID, 'event_testimonials', true);
    $testimonials = !empty($testimonials) ? json_decode($testimonials, true) : [];
    ?>
    <div id="testimonials-container">
        <?php foreach ($testimonials as $index => $testimonial): ?>
            <div class="testimonial">
                <hr>
                <h4>Testimonial <?php echo $index + 1; ?></h4>
                <p>
                    <label for="testimonials[<?php echo $index; ?>][name]">Name:</label><br>
                    <input type="text" name="testimonials[<?php echo $index; ?>][name]"
                        value="<?php echo esc_attr($testimonial['name']); ?>" placeholder="Enter name" class="widefat">
                </p>
                <p>
                    <label for="testimonials[<?php echo $index; ?>][text]">Testimonial:</label><br>
                    <textarea name="testimonials[<?php echo $index; ?>][text]" placeholder="Enter testimonial"
                        class="widefat"><?php echo esc_textarea($testimonial['text']); ?></textarea>
                </p>

                <!-- Image Upload Field -->
                <div class="testimonial-image">
                    <label>Image:</label><br>
                    <input type="hidden" class="testimonial-image-url" name="testimonials[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($testimonial['image'] ?? ''); ?>">
                    <img class="testimonial-image-preview" src="<?php echo esc_url($testimonial['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($testimonial['image']) ? 'block' : 'none'; ?>;"><br>
                    <button type="button" class="button upload-testimonial-image">Upload Image</button>
                    <button type="button" class="button remove-testimonial-image"
                        style="display: <?php echo !empty($testimonial['image']) ? 'inline-block' : 'none'; ?>;">Remove
                        Image</button>
                </div>

                <button type="button" class="button remove-testimonial">Remove Testimonial</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-testimonial" class="button">Add Testimonial</button>

    <script>
        jQuery(document).ready(function ($) {
            // Function to handle image upload
            function openMediaUploader(e) {
                e.preventDefault();

                const button = $(this);
                const parentDiv = button.closest('.testimonial-image');
                const imageUrlField = parentDiv.find('.testimonial-image-url');
                const imagePreview = parentDiv.find('.testimonial-image-preview');
                const removeButton = parentDiv.find('.remove-testimonial-image');

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

            // Add Testimonial Handler
            $('#add-testimonial').on('click', function () {
                const container = $('#testimonials-container');
                const index = container.children('.testimonial').length;

                const newTestimonial = `
                        <div class="testimonial">
                            <hr>
                            <h4>Testimonial ${index + 1}</h4>
                            <p>
                                <label for="testimonials[${index}][name]">Name:</label><br>
                                <input type="text" name="testimonials[${index}][name]" placeholder="Enter name" class="widefat">
                            </p>
                            <p>
                                <label for="testimonials[${index}][text]">Testimonial:</label><br>
                                <textarea name="testimonials[${index}][text]" placeholder="Enter testimonial" class="widefat"></textarea>
                            </p>

                            <!-- Image Upload Field -->
                            <div class="testimonial-image">
                                <label>Image:</label><br>
                                <input type="hidden" class="testimonial-image-url" name="testimonials[${index}][image]" value="">
                                <img class="testimonial-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;"><br>
                                <button type="button" class="button upload-testimonial-image">Upload Image</button>
                                <button type="button" class="button remove-testimonial-image" style="display: none;">Remove Image</button>
                            </div>

                            <button type="button" class="button remove-testimonial">Remove Testimonial</button>
                        </div>
                    `;
                container.append(newTestimonial);
            });

            // Handle Image Upload for Testimonials
            $(document).on('click', '.upload-testimonial-image', openMediaUploader);

            // Handle Image Removal for Testimonials
            $(document).on('click', '.remove-testimonial-image', function (e) {
                e.preventDefault();
                const parentDiv = $(this).closest('.testimonial-image');
                parentDiv.find('.testimonial-image-url').val('');
                parentDiv.find('.testimonial-image-preview').attr('src', '').hide();
                $(this).hide();
            });

            // Remove Testimonial Handler
            $(document).on('click', '.remove-testimonial', function () {
                $(this).closest('.testimonial').remove();
            });
        });
    </script>
    <?php
}

/**
 * 6. Render Top Brands Meta Box
 */
function render_event_top_brands_meta_box($post)
{
    // Add a nonce field for security
    wp_nonce_field('save_event_top_brands', 'event_top_brands_nonce');

    // Retrieve existing top brands
    $top_brands = get_post_meta($post->ID, 'event_top_brands', true);
    $top_brands = !empty($top_brands) ? json_decode($top_brands, true) : [];
    ?>
    <div id="top-brands-container">
        <?php foreach ($top_brands as $index => $brand): ?>
            <div class="top-brand">
                <hr>
                <h4>Brand <?php echo $index + 1; ?></h4>
                <!-- Image Upload Field -->
                <div class="brand-image">
                    <label>Logo:</label><br>
                    <input type="hidden" class="brand-image-url" name="event_top_brands[<?php echo $index; ?>][image]"
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
                const container = $('#top-brands-container');
                const index = container.children('.top-brand').length;

                const newBrand = `
                        <div class="top-brand">
                            <hr>
                            <h4>Brand ${index + 1}</h4>
                            <!-- Image Upload Field -->
                            <div class="brand-image">
                                <label>Logo:</label><br>
                                <input type="hidden" class="brand-image-url" name="event_top_brands[${index}][image]" value="">
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
                $(this).closest('.top-brand').remove();
            });
        });
    </script>
    <?php
}

/**
 * 7. Save Meta Box Data
 */
function save_event_details($post_id)
{
    // Check if our nonce is set.
    if (
        !isset($_POST['event_details_nonce']) ||
        !isset($_POST['event_speakers_nonce']) ||
        !isset($_POST['event_testimonials_nonce']) ||
        !isset($_POST['event_top_brands_nonce'])
    ) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['event_details_nonce'], 'save_event_details')) {
        return;
    }
    if (!wp_verify_nonce($_POST['event_speakers_nonce'], 'save_event_speakers')) {
        return;
    }
    if (!wp_verify_nonce($_POST['event_testimonials_nonce'], 'save_event_testimonials')) {
        return;
    }
    if (!wp_verify_nonce($_POST['event_top_brands_nonce'], 'save_event_top_brands')) {
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
     * 1. Save Event Details
     */
    if (isset($_POST['event_from_date'])) {
        update_post_meta($post_id, 'event_from_date', sanitize_text_field($_POST['event_from_date']));
    }

    if (isset($_POST['event_to_date'])) {
        update_post_meta($post_id, 'event_to_date', sanitize_text_field($_POST['event_to_date']));
    }

    if (isset($_POST['event_time'])) {
        update_post_meta($post_id, 'event_time', sanitize_text_field($_POST['event_time']));
    }

    if (isset($_POST['event_place'])) {
        update_post_meta($post_id, 'event_place', sanitize_text_field($_POST['event_place']));
    }

    if (isset($_POST['event_link'])) {
        update_post_meta($post_id, 'event_link', esc_url_raw($_POST['event_link']));
    }

    /**
     * 2. Save Speakers
     */
    if (isset($_POST['speakers']) && is_array($_POST['speakers'])) {
        $speakers = array_map(function ($speaker) {
            return array(
                'name' => sanitize_text_field($speaker['name']),
                'position' => sanitize_text_field($speaker['position']),
                'text' => sanitize_textarea_field($speaker['text']),
                'image' => esc_url_raw($speaker['image']),
            );
        }, $_POST['speakers']);
        update_post_meta($post_id, 'event_speakers', json_encode($speakers));
    }

    /**
     * 3. Save Testimonials
     */
    if (isset($_POST['testimonials']) && is_array($_POST['testimonials'])) {
        $testimonials = array_map(function ($testimonial) {
            return array(
                'name' => sanitize_text_field($testimonial['name']),
                'text' => sanitize_textarea_field($testimonial['text']),
                'image' => esc_url_raw($testimonial['image']),
            );
        }, $_POST['testimonials']);
        update_post_meta($post_id, 'event_testimonials', json_encode($testimonials));
    }

    /**
     * 4. Save Top Brands
     */
    if (isset($_POST['event_top_brands']) && is_array($_POST['event_top_brands'])) {
        $top_brands = array_map(function ($brand) {
            return array(
                'image' => esc_url_raw($brand['image']),
            );
        }, $_POST['event_top_brands']);
        update_post_meta($post_id, 'event_top_brands', json_encode($top_brands));
    }
}
add_action('save_post_events', 'save_event_details');

/**
 * 8. Enqueue Scripts for Media Uploader
 */
function enqueue_event_meta_box_scripts($hook)
{
    // Only enqueue scripts on the Events edit screen
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    global $post;
    if ($post->post_type !== 'events') {
        return;
    }

    // Enqueue WordPress media uploader
    wp_enqueue_media();

    // Enqueue jQuery (already included in WordPress by default)
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'enqueue_event_meta_box_scripts');
?>