<div class="container">
    <div class="row mb-4">
        <?php
        // Custom query for co_horts post type
        $co_horts_query = new WP_Query(array(
            'post_type' => 'co_horts',
            'posts_per_page' => 6, // Change as per your requirement
        ));

        if ($co_horts_query->have_posts()):
            $post_counter = 0;
            while ($co_horts_query->have_posts()):
                $co_horts_query->the_post();

                // Add a new row for every 3 posts
                if ($post_counter % 3 == 0 && $post_counter != 0) {
                    echo '</div><div class="row mb-4">';
                }
                ?>
                <div class="col-md-4">
                    <div class="card" style="overflow:hidden">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title mb-3"><?php the_title(); ?></h3>
                            <div class="card-text mb-3"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="text-primary fw-semibold">Read more <i
                                    class="fa-solid fa-angles-right"></i></a>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <img src="<?php echo get_template_directory_uri(); ?>../Images/line-<?php
                                   if ($post_counter % 3 == 0) {
                                       echo 'blue';
                                   } elseif ($post_counter % 3 == 1) {
                                       echo 'red';
                                   } else {
                                       echo 'green';
                                   }
                                   ?>.png" alt="line">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $post_counter++;
            endwhile;
            wp_reset_postdata();
        else: ?>
            <p><?php esc_html_e('No Co-horts found.', 'textdomain'); ?></p>
        <?php endif; ?>
    </div>
</div>