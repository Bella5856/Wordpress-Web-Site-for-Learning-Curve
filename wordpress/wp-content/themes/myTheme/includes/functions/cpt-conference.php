<?php

function post_type_conference()
{
    $args = array(
        'labels' => array(
            'name' => 'Conferences',
            'singular_name' => 'Conference',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'conference'),
    );
    register_post_type('conference', $args);
}
add_action('init', 'post_type_conference');

function conference_speakers_meta_box()
{
    add_meta_box(
        'conference_speakers',
        'Speakers',
        'render_speakers_meta_box',
        'conference',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'conference_speakers_meta_box');

function render_speakers_meta_box($post)
{
    $speakers = get_post_meta($post->ID, 'conference_speakers', true);
    $speakers = !empty($speakers) ? json_decode($speakers, true) : [];
    ?>
    <div id="speakers-container">
        <?php foreach ($speakers as $index => $speaker): ?>
            <div class="speaker">
                <input type="text" name="speakers[<?php echo $index; ?>][name]" placeholder="Name"
                    value="<?php echo esc_attr($speaker['name']); ?>">
                <input type="text" name="speakers[<?php echo $index; ?>][position]" placeholder="Position"
                    value="<?php echo esc_attr($speaker['position']); ?>">
                <textarea name="speakers[<?php echo $index; ?>][text]"
                    placeholder="Description"><?php echo esc_textarea($speaker['text']); ?></textarea>

                <!-- Image Upload Field -->
                <div class="speaker-image">
                    <input type="hidden" class="speaker-image-url" name="speakers[<?php echo $index; ?>][image]"
                        value="<?php echo esc_url($speaker['image'] ?? ''); ?>">
                    <img class="speaker-image-preview" src="<?php echo esc_url($speaker['image'] ?? ''); ?>"
                        style="max-width: 100px; max-height: 100px; display: <?php echo !empty($speaker['image']) ? 'block' : 'none'; ?>;">
                    <button type="button" class="upload-speaker-image button">Upload Image</button>
                    <button type="button" class="remove-speaker-image button"
                        style="display: <?php echo !empty($speaker['image']) ? 'inline-block' : 'none'; ?>;">Remove
                        Image</button>
                </div>

                <button type="button" class="remove-speaker">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-speaker">Add Speaker</button>

    <script>
        jQuery(document).ready(function ($) {
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
                const index = container.children().length;

                const newSpeaker = $(`
                        <div class="speaker">
                            <input type="text" name="speakers[${index}][name]" placeholder="Name">
                            <input type="text" name="speakers[${index}][position]" placeholder="Position">
                            <textarea name="speakers[${index}][text]" placeholder="Description"></textarea>

                            <div class="speaker-image">
                                <input type="hidden" class="speaker-image-url" name="speakers[${index}][image]" value="">
                                <img class="speaker-image-preview" src="" style="max-width: 100px; max-height: 100px; display: none;">
                                <button type="button" class="upload-speaker-image button">Upload Image</button>
                                <button type="button" class="remove-speaker-image button" style="display: none;">Remove Image</button>
                            </div>

                            <button type="button" class="remove-speaker">Remove</button>
                        </div>
                    `);
                container.append(newSpeaker);
            });

            // Handle Image Upload
            $(document).on('click', '.upload-speaker-image', openMediaUploader);

            // Handle Image Removal
            $(document).on('click', '.remove-speaker-image', function (e) {
                e.preventDefault();

                const parentDiv = $(this).closest('.speaker-image');
                parentDiv.find('.speaker-image-url').val('');
                parentDiv.find('.speaker-image-preview').hide();
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

function save_conference_speakers($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!isset($_POST['speakers']))
        return;

    $speakers = $_POST['speakers'];
    update_post_meta($post_id, 'conference_speakers', json_encode($speakers));
}
add_action('save_post', 'save_conference_speakers');

function conference_subjects_meta_box()
{
    add_meta_box(
        'conference_subjects',
        'Subjects of Discussion',
        'render_subjects_meta_box',
        'conference',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'conference_subjects_meta_box');

function render_subjects_meta_box($post)
{
    $subjects = get_post_meta($post->ID, 'conference_subjects', true);
    $subjects = !empty($subjects) ? json_decode($subjects, true) : [];
    ?>
    <div id="subjects-container">
        <?php foreach ($subjects as $index => $subject): ?>
            <div class="subject">
                <input type="text" name="subjects[<?php echo $index; ?>][title]" placeholder="Subject Title"
                    value="<?php echo esc_attr($subject['title']); ?>">
                <button type="button" class="remove-subject">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" id="add-subject">Add Subject</button>
    <script>
        document.getElementById('add-subject').onclick = function () {
            const container = document.getElementById('subjects-container');
            const index = container.children.length;
            const newSubject = document.createElement('div');
            newSubject.classList.add('subject');
            newSubject.innerHTML = `
                                        <input type="text" name="subjects[${index}][title]" placeholder="Subject Title">
                                        <button type="button" class="remove-subject">Remove</button>
                                    `;
            container.appendChild(newSubject);
        };
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-subject')) {
                e.target.parentElement.remove();
            }
        });
    </script>
    <?php
}

function save_conference_subjects($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!isset($_POST['subjects']))
        return;

    $subjects = $_POST['subjects'];
    update_post_meta($post_id, 'conference_subjects', json_encode($subjects));
}
add_action('save_post', 'save_conference_subjects');

// Add Date, Time, and Place Meta Box
function conference_date_time_place_meta_box()
{
    add_meta_box(
        'conference_date_time_place',
        'Conference Date, Time, Place, and Link',
        'render_date_time_place_meta_box',
        'conference',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'conference_date_time_place_meta_box');

function render_date_time_place_meta_box($post)
{
    $from_date = get_post_meta($post->ID, 'conference_from_date', true); // From Date
    $to_date = get_post_meta($post->ID, 'conference_to_date', true); // To Date
    $time = get_post_meta($post->ID, 'conference_time', true);
    $place = get_post_meta($post->ID, 'conference_place', true);
    $link = get_post_meta($post->ID, 'conference_link', true); // Link Field
    ?>
    <label for="conference_from_date">From Date:</label>
    <input type="date" id="conference_from_date" name="conference_from_date" value="<?php echo esc_attr($from_date); ?>">
    <br>
    <label for="conference_to_date">To Date:</label>
    <input type="date" id="conference_to_date" name="conference_to_date" value="<?php echo esc_attr($to_date); ?>">
    <br>
    <label for="conference_time">Time:</label>
    <input type="time" id="conference_time" name="conference_time" value="<?php echo esc_attr($time); ?>">
    <br>
    <label for="conference_place">Place:</label>
    <input type="text" id="conference_place" name="conference_place" value="<?php echo esc_attr($place); ?>">
    <br>
    <label for="conference_link">Link:</label>
    <input type="url" id="conference_link" name="conference_link" value="<?php echo esc_attr($link); ?>">
    <!-- New Link Field -->
    <?php
}

function save_conference_date_time_place($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // Save from date
    if (isset($_POST['conference_from_date'])) {
        update_post_meta($post_id, 'conference_from_date', sanitize_text_field($_POST['conference_from_date']));
    }

    // Save to date
    if (isset($_POST['conference_to_date'])) {
        update_post_meta($post_id, 'conference_to_date', sanitize_text_field($_POST['conference_to_date']));
    }

    // Save time
    if (isset($_POST['conference_time'])) {
        update_post_meta($post_id, 'conference_time', sanitize_text_field($_POST['conference_time']));
    }

    // Save place
    if (isset($_POST['conference_place'])) {
        update_post_meta($post_id, 'conference_place', sanitize_text_field($_POST['conference_place']));
    }

    // Save link
    if (isset($_POST['conference_link'])) {
        update_post_meta($post_id, 'conference_link', esc_url($_POST['conference_link'])); // Save the link
    }
}
add_action('save_post', 'save_conference_date_time_place');
