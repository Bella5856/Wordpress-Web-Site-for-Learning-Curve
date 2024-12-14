<?php
// single-co_horts.php

get_header();




if (have_posts()):
    while (have_posts()):
        the_post();
        // Your cohort details here...

        // Fetch testimonials
        $testimonials = json_decode(get_post_meta(get_the_ID(), 'cohorts_testimonials', true), true);
        ?>

        <?php
        // Retrieve the Cohort Link from post meta
        $cohort_link = get_post_meta(get_the_ID(), 'cohorts_cohort_link', true);

        // Retrieve the Banner Image URL
        $banner_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        ?>
        <div class="container-section">
            <div class="event-banner-single about-banner" style="    border-radius:0px; background-image:linear-gradient(
            270deg,
            rgba(238, 247, 255, 0.001) 0%,
            rgba(145, 173, 244, 0.405) 50%,
            rgba(34, 54, 110, 0.803) 80%
        ),
        url('<?php echo esc_url($banner_image_url); ?>'); ">

                <div class="container">
                    <div class="row">
                        <div class="col-md-4 content">
                            <h2 class="fs-1"><?php the_title(); ?></h2>
                            <p><?php the_excerpt(); ?></p>
                            <br>
                            <?php if (!empty($cohort_link)): ?>
                                <a href="<?php echo esc_url($cohort_link); ?>" class="whitebtn">Reserve Your Spot</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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





get_footer();
?>