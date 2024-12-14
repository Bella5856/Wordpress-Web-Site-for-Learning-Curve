<div class="container">
    <div class="row">
        <div class="col-md-4"> <!-- First Column -->
            <div class="mb-3">
                <img src="<?php echo get_template_directory_uri(); ?>/Images/starttestimonials.png" alt="Image 1"
                    class="img-fluid">
            </div>
            <?php
            // Fetch testimonials from the custom post type
            $testimonial_args = array(
                'post_type' => 'testimonials',
                'posts_per_page' => 2, // Fetch only 2 testimonials
            );
            $testimonial_query = new WP_Query($testimonial_args);

            if ($testimonial_query->have_posts()):
                while ($testimonial_query->have_posts()):
                    $testimonial_query->the_post();
                    // Display the testimonial image
                    if (has_post_thumbnail()): ?>
                        <div class="mb-3">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                        </div>
                    <?php endif;
                endwhile;
                wp_reset_postdata();
            else: ?>
                <p>No testimonials found.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4"> <!-- Second Column -->
            <?php
            // Assuming you want to repeat the same for the second column
            $testimonial_args = array(
                'post_type' => 'testimonials',
                'posts_per_page' => 3, // Fetch 3 testimonials for this column
                'offset' => 2, // Offset the first two from the previous column
            );
            $testimonial_query = new WP_Query($testimonial_args);

            if ($testimonial_query->have_posts()):
                while ($testimonial_query->have_posts()):
                    $testimonial_query->the_post();
                    // Display the testimonial image
                    if (has_post_thumbnail()): ?>
                        <div class="mb-3">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                        </div>
                    <?php endif;
                endwhile;
                wp_reset_postdata();
            else: ?>
                <p>No testimonials found.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4"> <!-- Third Column -->
            <?php
            // Assuming you want to repeat the same for the third column
            $testimonial_args = array(
                'post_type' => 'testimonials',
                'posts_per_page' => 2, // Fetch only 2 testimonials
                'offset' => 5, // Offset to get the next two testimonials
            );
            $testimonial_query = new WP_Query($testimonial_args);

            if ($testimonial_query->have_posts()):
                while ($testimonial_query->have_posts()):
                    $testimonial_query->the_post();
                    // Display the testimonial image
                    if (has_post_thumbnail()): ?>
                        <div class="mb-3">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="img-fluid">
                        </div>
                    <?php endif;
                endwhile;
                wp_reset_postdata();
            else: ?>
                <p>No testimonials found.</p>
            <?php endif; ?>
            <div class="mb-3">
                <img src="<?php echo get_template_directory_uri(); ?>/Images/endtestimonials.png" alt="Image 9"
                    class="img-fluid">
            </div>
        </div>
    </div>
</div>