<div class="section-guides">

    <div class="row mb-4">
        <?php
        $guides_query = new WP_Query(array(
            'post_type' => 'guides',
            'posts_per_page' => 6,
        ));
        if ($guides_query->have_posts()):
            $post_counter = 0;
            while ($guides_query->have_posts()):
                $guides_query->the_post();
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
                    </div>
                </div>
                <?php
                $post_counter++;
            endwhile;
            wp_reset_postdata();
        else:
            echo '<p>No guides found.</p>';
        endif;
        ?>
    </div>
</div>