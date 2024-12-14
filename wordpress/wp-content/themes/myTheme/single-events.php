<?php get_header(); ?>
<div class="display-none header-container text-center container-section">
    <br>
    <h2>Events</h2>
    <p>Creative ideas, practical tips and insider info - Learning Curve blog </p>
</div>
<div class="container-section container">
    <?php
    // Assuming you are on the single event page, use get_the_ID() to fetch the current post data
    $post_id = get_the_ID();

    // Get the featured image URL
    $banner_image_url = get_the_post_thumbnail_url($post_id, 'full');

    // Get the meta values for the current event
    $from_date = get_post_meta($post_id, '_from_date', true);
    $to_date = get_post_meta($post_id, '_to_date', true);
    $time = get_post_meta($post_id, '_event_time', true);
    $place = get_post_meta($post_id, '_event_place', true);
    $link = get_post_meta($post_id, '_event_link', true);

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

    <div class="event-banner-single about-banner" style="background-image:linear-gradient(
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
                        <p class="fs-5 fw-bolder mb-1">
                            <?php echo esc_html($formatted_from_day) . ' - ' . esc_html($formatted_to_day); ?>
                        </p>
                        <!-- Display date with suffix -->
                        <p class="fs-5 fw-bolder">Of <?php echo esc_html($from_month); ?></p>
                        <!-- Display month on the next line -->
                    <?php endif; ?>
                    <h2 class="fs-1"><?php the_title(); ?></h2>
                    <p class="mobile-none"><?php the_excerpt(); ?></p>
                    <br class="mobile-none">
                    <a href="<?php echo esc_url($link); ?>" class="whitebtn mobile-none">Reserve Your Spot</a>
                    <!-- Button for the link -->
                </div>
            </div>
        </div>
    </div>
    <br class="display-none">
    <a href="<?php echo esc_url($link); ?>" class="display-none blue-btn ">Reserve Your Spot</a>

</div>

<div class="container container-section mobile-none">

    <?php
    $top_brands = get_post_meta(get_the_ID(), 'event_top_brands', true);
    $top_brands = !empty($top_brands) ? json_decode($top_brands, true) : [];
    ?>

    <?php if (!empty($top_brands)): ?>
        <div class="top-brands-section">
            <div class="header-container text-center">
                <h3>Featuring Speakers of Today's Top Brands</h3>

            </div>
            <div class="top-brands-logos">
                <?php foreach ($top_brands as $brand):
                    if (!empty($brand['image'])): ?>
                        <div class="brand-logo">
                            <img src="<?php echo esc_url($brand['image']); ?>" alt="Brand Logo">
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
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
        // Retrieve the speakers meta field from the current event post
        $speakers = get_post_meta(get_the_ID(), '_event_speakers', true);
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


<?php


if (have_posts()):
    while (have_posts()):
        the_post();
        // Your event details here...

        // Fetch testimonials
        $testimonials = json_decode(get_post_meta(get_the_ID(), 'event_testimonials', true), true);
        ?>

        <div class="container container-section">
            <div class="header-container text-center">
                <h3>See What Attendees Say</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
                <br>
            </div>
            <div class="carousel slide" id="testimonialCarousel" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    if (!empty($testimonials)):
                        foreach ($testimonials as $index => $testimonial):
                            $active_class = ($index === 0) ? 'active' : ''; // Set the first testimonial as active
                            ?>
                            <div class="carousel-item <?php echo esc_attr($active_class); ?> events-carusel">
                                <div class="inner">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="<?php echo esc_url($testimonial['image']); ?>" alt="Testimonial"
                                                class="img-fluid">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="content">
                                                <p><?php echo esc_html($testimonial['text']); ?></p>

                                                <p class="testimonial-name"> — <?php echo esc_html($testimonial['name']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No testimonials available.</p>
                    <?php endif; ?>
                </div>
                <a class="carousel-control-prev" href="#testimonialCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#testimonialCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <?php
    endwhile;
endif;

?>
<div class="container-section">
    <div class="container display-none event-section-mobile">

        <h3>Participate and Start Learning</h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cumque iure dolorem laudantium modi
            dolore, unde tempora quod saepe quasi. Distinctio.</p>
        <br>
        <a href="<?php echo esc_url($link); ?>" target="blank" class="whitebtn">Book Your Spot</a>
    </div>
</div>

<div class=" container container-section mobile-none">



    <div class=" event-banner py-5">

        <div class="container">
            <div class="row">
                <div class="col-md-4 content">
                    <h3>Participate and Start Learning</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cumque iure dolorem laudantium modi
                        dolore, unde tempora quod saepe quasi. Distinctio.</p>
                    <a href="<?php echo esc_url($link); ?>" target="blank" class="blue-btn">Book Your Spot</a>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="events container container-section">
    <div class="header-container text-center">
        <h3>Upcoming Events</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, accusantium?</p>
        <br>
    </div>
    <?php get_template_part('includes/section', 'events'); ?>
</div>
<?php get_template_part('subscribe-to-our-newsletter'); ?>
<?php get_footer(); ?>