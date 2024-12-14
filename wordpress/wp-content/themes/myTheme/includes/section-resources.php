<div class="section-free-resources">
    <div class="row mb-4">
        <?php
        $free_resources_query = new WP_Query(array(
            'post_type' => 'free_resources',
            'posts_per_page' => 6,
        ));
        if ($free_resources_query->have_posts()):
            $post_counter = 0;
            while ($free_resources_query->have_posts()):
                $free_resources_query->the_post();
                if ($post_counter % 3 == 0 && $post_counter != 0) {
                    echo '</div><div class="row mb-4">';
                }
                ?>
                <div class="col-md-4">
                    <div class="card">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title mb-3"><?php the_title(); ?></h3>
                            <div class="card-text mb-3"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="text-primary fw-semibold classic-link">Learn More
                            </a>
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
        else:
            echo '<p>No free resources found.</p>';
        endif;
        ?>
    </div>
</div>