<div class="conference-mobile">
    <div class=" container ">
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
                ?>
                <div class="blog-banner conference-banner py-5" style="background-image:linear-gradient(
    90deg,
    rgba(30, 56, 131, 1) 0%,
    rgba(160, 178, 232, 1) 35%,
    rgba(255, 255, 255, 0) 35%
  ), url('<?php echo esc_url($banner_image_url); ?>'); ">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 content">
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                    <style>
                        @media (max-width: 767px) {
                            .conference-banner {
                                background-image: url('<?php echo esc_url($banner_image_url); ?>') !important;
                            }
                        }
                    </style>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else:
            ?>
            <p><?php esc_html_e('No conferences found.', 'textdomain'); ?></p>
        <?php endif; ?>
    </div>
</div>