<!-- <?php //if (have_posts()):
// while (have_posts()):
// the_post(); ?>

        <h3><?php //the_title(); ?></h3>
        <div><?php //the_excerpt(); ?></div>
        <a href="<?php //the_permalink(); ?>">Read more</a>

    <?php //endwhile; else: endif; ?> -->




<div class="cards-container container">
    <div id="post-container">
        <?php if (have_posts()):
            $post_counter = 0;
            while (have_posts()):
                the_post();
                $author_id = get_the_author_meta('ID');
                $author_avatar = get_avatar($author_id, 96);
                $post_id = get_the_ID();
                $reading_time = get_reading_time($post_id);

                $categories = wp_get_post_terms(get_the_ID(), 'blog_category', array('fields' => 'slugs'));
                $tags = wp_get_post_terms(get_the_ID(), 'blog_tags', array('fields' => 'slugs'));
                ?>
                <div class="col-md-4 post-item" data-categories="<?php echo esc_attr(implode(',', $categories)); ?>"
                    data-tags="<?php echo esc_attr(implode(',', $tags)); ?>">
                    <div class="card mb-4 blog-card">
                        <div class="card-body">
                            <?php if (has_post_thumbnail()): ?>
                                <img class="blog-card-img" src="<?php the_post_thumbnail_url(); ?>" class="card-img-top"
                                    alt="<?php the_title(); ?>">
                            <?php endif; ?>
                            <div class="blog-author">
                                <div class="author-avatar">
                                    <?php echo $author_avatar; ?>
                                </div>
                                <div class="author">
                                    <p><small><?php echo get_the_author(); ?></small></p>
                                    <p><small><?php echo get_the_date(); ?></small></p>
                                </div>
                            </div>
                            <h3 class="card-title mb-3"><?php the_title(); ?></h3>

                            <!-- Trim the excerpt to match dynamically loaded posts -->
                            <div class="card-text mb-3">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); // Adjust number 20 for desired length ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="text-primary fw-semibold">Read more</a>

                            <div class="post-meta">
                                <span class="reading-time"><?php echo esc_html($reading_time); ?> min read</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6"><img src="<?php echo get_template_directory_uri(); ?> ../Images/line-blue.png"
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