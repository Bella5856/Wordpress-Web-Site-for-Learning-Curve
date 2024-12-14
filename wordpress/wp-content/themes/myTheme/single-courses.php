<?php get_header(); ?>
<?php
if (have_posts()):
    while (have_posts()):
        the_post();

        // Fetch custom fields
        $button_text = get_post_meta(get_the_ID(), 'button_text', true);
        $button_link = get_post_meta(get_the_ID(), 'button_link', true);
        $additional_image = get_field('additional_image'); // Image Array
        $course_features = get_post_meta(get_the_ID(), 'course_features', true);
        $financial_options = get_post_meta(get_the_ID(), 'financial_options', true);

        // Decode JSON-encoded fields if they exist
        $course_features = !empty($course_features) ? json_decode($course_features, true) : [];
        $financial_options = !empty($financial_options) ? json_decode($financial_options, true) : [];

        // Get the full post content
        $full_content = apply_filters('the_content', get_the_content());

        // Split the content into the first block and remaining content
        $pattern = '/^(.*?<\/(p|h[1-6]|ul|ol|div|blockquote)>)/is';
        if (preg_match($pattern, $full_content, $matches)) {
            $first_block = $matches[1];
            $remaining_content = substr($full_content, strlen($matches[1]));
        } else {
            // If no match, assign all content to remaining_content
            $first_block = '';
            $remaining_content = $full_content;
        }
        ?>

        <div class="container container-section">
            <div class="comunity-banner about-banner courses-single-banner">

                <div class="container">
                    <div class="row">
                        <div class="col-md-4 content">
                            <!-- Dynamic Title -->
                            <h3><?php the_title(); ?></h3>

                            <!-- Dynamic First Block -->
                            <?php if (!empty($first_block)): ?>
                                <?php echo wp_kses_post($first_block); ?>
                            <?php endif; ?>

                            <?php
                            // Get current user ID
                            $user_id = get_current_user_id();

                            // Get the linked WooCommerce product ID
                            $product_id = get_post_meta(get_the_ID(), '_course_product_id', true);

                            // Get the linked Course Video Link
                            $video_link = get_post_meta(get_the_ID(), 'course_video_link', true);

                            // Get the WooCommerce "My Account" page URL
                            $my_account_page_id = wc_get_page_id('myaccount');
                            if ($my_account_page_id > 0) {
                                $my_account_url = get_permalink($my_account_page_id);
                            } else {
                                // Fallback URL if "My Account" page is not set
                                $my_account_url = site_url('/my-account/');
                            }

                            // Initialize button variables
                            $button_url = '#';
                            $button_text = 'Join Now';

                            if (is_user_logged_in()) {
                                if ($product_id) {
                                    // Check if the user has purchased the product
                                    if (wc_customer_bought_product('', $user_id, $product_id)) {
                                        // User has purchased the course
                                        if (!empty($video_link)) {
                                            $button_url = esc_url($video_link);
                                            $button_text = 'Access Course Videos';
                                        } else {
                                            $button_url = '#';
                                            $button_text = 'Video Link Not Available';
                                        }
                                    } else {
                                        // User has not purchased the course
                                        $product = wc_get_product($product_id);
                                        if ($product) {
                                            $button_url = esc_url(get_permalink($product_id));
                                            $button_text = 'Reserve Your Spot';
                                        }
                                    }
                                }
                            } else {
                                // User is not logged in
                                $button_url = esc_url($my_account_url);
                                $button_text = 'Login to Join';
                            }
                            ?>

                            <!-- Dynamic Button as a Link -->
                            <a href="<?php echo $button_url; ?>" class="blue-btn mobile-none">
                                <?php echo esc_html($button_text); ?>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <br class="display-none">
            <a href="<?php echo $button_url; ?>" class="blue-btn display-none">
                <?php echo esc_html($button_text); ?>
            </a>
        </div>


        <!-- Additional Content Section -->
        <div class="container container-section">
            <div class="additional-content-section">
                <div class="row">
                    <!-- Left Column: Remaining Content (col-md-8) -->
                    <div class="col-md-8 content">
                        <?php if (!empty($additional_image)): ?>
                            <div class="additional-image mb-4">
                                <img src="<?php echo esc_url($additional_image['url']); ?>"
                                    alt="<?php echo esc_attr($additional_image['alt']); ?>" class="img-fluid">
                            </div>
                        <?php else: ?>
                            <!-- Optional: Placeholder Image -->
                            <div class="additional-image mb-4">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/placeholder.png'); ?>"
                                    alt="Placeholder Image" class="img-fluid">
                            </div>
                        <?php endif; ?>

                        <?php echo wp_kses_post($remaining_content); ?>
                        <div class="mt-4">
                            <form action="">
                                <input placeholder="Enter your email address" class="course-email" type="email" name="email"
                                    id="email">
                                <button class="blue-btn" type="submit">Start Now</button>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column: Course Features and Financial Options (col-md-4) -->
                    <div class="col-md-4 content">
                        <!-- Course Features -->
                        <div class="features-container">
                            <?php if (!empty($course_features)): ?>
                                <div class="course-features mb-4">
                                    <h3>Course Features</h3>
                                    <ul>
                                        <?php foreach ($course_features as $feature): ?>
                                            <li>
                                                <strong><?php echo esc_html($feature['name']); ?>:</strong>
                                                <?php echo esc_html($feature['description']); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Financial Options -->
                            <?php if (!empty($financial_options)): ?>
                                <div class="financial-options">
                                    <h3>Financial Options</h3>
                                    <ul>
                                        <?php foreach ($financial_options as $option): ?>
                                            <li>
                                                <strong><?php echo esc_html($option['option']); ?>:</strong>
                                                <?php echo esc_html($option['description']); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    endwhile;
endif;
?>
<div class="display-none">
    <?php get_template_part('save-your-spot'); ?>
    <br>
    <br>
</div>
<div class="container container-section">
    <div class="header-container text-center">
        <h3>Mentors</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>
    <div class="row mb-4">
        <?php
        // Retrieve mentors from the meta field
        $mentors = get_post_meta(get_the_ID(), 'mentors', true);
        $mentors = !empty($mentors) ? json_decode($mentors, true) : [];

        if (!empty($mentors)):
            foreach ($mentors as $mentor): ?>
                <div class="col-md-4">
                    <div class="card" style="overflow:hidden">
                        <!-- Mentor Image -->
                        <?php if (!empty($mentor['image'])): ?>
                            <img src="<?php echo esc_url($mentor['image']); ?>" class="card-img-top"
                                alt="<?php echo esc_attr($mentor['name']); ?>">
                        <?php else: ?>
                            <!-- Optional: Placeholder Image -->
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/Images/placeholder.png'); ?>"
                                class="card-img-top" alt="No Image Available">
                        <?php endif; ?>

                        <div class="card-body">
                            <h3 class="card-title mb-3"><?php echo esc_html($mentor['name']); ?></h3>
                            <p class="card-text mb-3"><?php echo esc_html($mentor['position']); ?></p>
                            <div class="card-text mb-3"><?php echo esc_html($mentor['description']); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <img src="<?php echo get_template_directory_uri(); ?>/Images/line-red.png" alt="line">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No mentors available.</p>
        <?php endif; ?>
    </div>
</div>

<div class="container-section">
    <div class="container header-container text-center">
        <h3>Testimonials</h3>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Explicabo, eligendi?</p>
        <br>
    </div>
    <?php get_template_part('includes/section', 'testimonials'); ?>

</div>

<div><?php get_template_part('includes/section', 'faq'); ?></div>


<div class="display-none">
    <?php get_template_part('save-your-spot'); ?>
</div>

<div class=" container  mobile-none">
    <div class="comunity-banner about-banner ">

        <div class="container">
            <div class="row">
                <div class="col-md-4 content">
                    <h3>Develop your skills in a new unique way</h3>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam laudantium quasi optio officiis
                        explicabo
                        doloremque? Dicta aliquid vitae nostrum voluptatem, explicabo perspiciatis facilis quos cumque!
                    </p>
                    <button>Joun Our Comunity</button>
                </div>

            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>