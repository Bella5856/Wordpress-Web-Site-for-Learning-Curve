<?php get_header(); ?>

<div class="container-section">
    <?php
    // Query to get the latest conference post
    $conference_query = new WP_Query(array(
        'posts_per_page' => 1, // You can adjust the number of posts if needed
        'post_type' => 'conference', // Querying the conference post type
    ));

    if ($conference_query->have_posts()):
        while ($conference_query->have_posts()):
            $conference_query->the_post();

            // Get the featured image URL
            $banner_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

            // Get the meta values for the conference
            $from_date = get_post_meta(get_the_ID(), 'conference_from_date', true);
            $to_date = get_post_meta(get_the_ID(), 'conference_to_date', true);
            $time = get_post_meta(get_the_ID(), 'conference_time', true);
            $place = get_post_meta(get_the_ID(), 'conference_place', true);
            $link = get_post_meta(get_the_ID(), 'conference_link', true);

            // Function to add the appropriate suffix (st, nd, rd, th)
            function add_date_suffix($day)
            {
                if (!in_array(($day % 100), array(11, 12, 13))) {
                    switch ($day % 10) {
                        case 1:
                            return $day . 'st';
                        case 2:
                            return $day . 'nd';
                        case 3:
                            return $day . 'rd';
                    }
                }
                return $day . 'th';
            }

            // Ensure that from_date and to_date are valid
            if ($from_date && $to_date) {
                // Format the from and to dates
                $from_day = date('j', strtotime($from_date)); // Day without leading zeros
                $to_day = date('j', strtotime($to_date)); // Day without leading zeros
                $from_month = date('F', strtotime($from_date)); // Full month name
    
                // Add the suffix to the days
                $formatted_from_day = add_date_suffix($from_day);
                $formatted_to_day = add_date_suffix($to_day);
            }

            ?>
            <div class="conference-banner-single" style="background-image:linear-gradient(
                270deg,
                rgba(238, 247, 255, 0.001) 0%,
                rgba(145, 173, 244, 0.405) 50%,
                rgba(34, 54, 110, 0.803) 80%
            ),
            url('<?php echo esc_url($banner_image_url); ?>');">

                <div class="container">
                    <div class="row">
                        <div class="col-md-4 content">
                            <?php if ($from_date && $to_date): ?>
                                <p class="fs-5 fw-bolder">
                                    <?php echo esc_html($formatted_from_day) . ' - ' . esc_html($formatted_to_day); ?>
                                </p>
                                <!-- Display date with suffix -->
                                <p class="fs-5 fw-bolder"> <?php echo esc_html($from_month); ?></p>
                                <!-- Display month on the next line -->
                            <?php endif; ?>
                            <h2 class="fs-1"><?php the_title(); ?></h2>
                            <p><?php the_excerpt(); ?></p>
                            <br>
                            <a href="<?php echo esc_url($link); ?>" class="whitebtn">Reserve Your Spot</a>
                            <!-- Button for the link -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else:
        ?>
        <p><?php esc_html_e('No conferences found.', 'textdomain'); ?></p>
    <?php endif; ?>
</div>

<!-- Speakers Section -->

<div class="container container-section">
    <div class="header-container text-center">
        <h3>Subjects of our discusion</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>

    <?php
    // Retrieve subjects from the post meta
    $subjects = get_post_meta(get_the_ID(), 'conference_subjects', true);
    $subjects = !empty($subjects) ? json_decode($subjects, true) : [];

    if (!empty($subjects)): ?>
        <section class="conference-subjects">

            <div id="subjects-carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($subjects as $index => $subject): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="subject-item">
                                <h3><?php echo esc_html($subject['title']); ?></h3>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#subjects-carousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#subjects-carousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    <?php endif; ?>


</div>



<div class="container container-section">
    <div class="header-container text-center">
        <h3>Speakers</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>
    <div class="row mb-4">
        <?php
        // Retrieve speakers from the meta field
        $speakers = get_post_meta(get_the_ID(), 'conference_speakers', true);
        $speakers = !empty($speakers) ? json_decode($speakers, true) : [];

        if (!empty($speakers)):
            foreach ($speakers as $speaker): ?>
                <div class="col-md-4">
                    <div class="card" style="overflow:hidden">
                        <!-- Placeholder for Speaker Image if Available -->
                        <?php if (!empty($speaker['image'])): ?>
                            <img src="<?php echo esc_url($speaker['image']); ?>" class="card-img-top"
                                alt="<?php echo esc_attr($speaker['name']); ?>">
                        <?php endif; ?>

                        <div class="card-body">
                            <h3 class="card-title mb-3"><?php echo esc_html($speaker['name']); ?></h3>
                            <p class="card-text mb-3"> <?php echo esc_html($speaker['position']); ?>
                            </p>
                            <div class="card-text mb-3"><?php echo esc_html($speaker['text']); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <img src="<?php echo get_template_directory_uri(); ?>../Images/line-red.png" alt="line">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No speakers available.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_template_part('save-your-spot'); ?>
<?php get_footer(); ?>