<div class="container">
    <div class="row mb-4" id="post-container">
        <?php if (have_posts()):
            $post_counter = 0;
            while (have_posts()):
                the_post();
                if ($post_counter % 3 == 0 && $post_counter != 0) {
                    echo '</div><div class="row mb-4">';
                }
                $categories = wp_get_post_terms(get_the_ID(), 'blog_category', array('fields' => 'slugs'));
                $tags = wp_get_post_terms(get_the_ID(), 'blog_tags', array('fields' => 'slugs'));
                ?>
                <div class="col-md-4 post-item" data-categories="<?php echo esc_attr(implode(',', $categories)); ?>"
                    data-tags="<?php echo esc_attr(implode(',', $tags)); ?>">
                    <div class="card mb-4 blog-card">
                        <div class="card-body">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url(); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <h3 class="card-title mb-3"><?php the_title(); ?></h3>
                            <div class="card-text mb-3"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="text-primary fw-semibold">Read more <i
                                    class="fa-solid fa-angles-right"></i></a>
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