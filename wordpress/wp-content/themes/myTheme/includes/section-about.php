<div class="container">
    <div class="row mb-4">
        <?php if (have_posts()):
            $post_counter = 0;
            while (have_posts()):
                the_post();

                if ($post_counter % 3 == 0 && $post_counter != 0) {
                    echo '</div><div class="row mb-4 ">';
                }
                ?>
                <div class="col-md-4">
                    <div class="card " style="overflow:hidden">
                        <?php if (has_post_thumbnail()): ?>
                            <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title mb-3"><?php the_title(); ?></h3>
                            <div class="card-text mb-3"><?php the_excerpt(); ?></div>

                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6"><img src="<?php echo get_template_directory_uri(); ?> ../Images/line-red.png"
                                    alt="line">
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $post_counter++;
            endwhile;
        else: ?>
            <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
        <?php endif; ?>
    </div>
</div>