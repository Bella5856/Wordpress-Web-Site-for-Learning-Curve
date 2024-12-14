<div class="related-posts container mt-5">
    <div class="row align-margin">
        <?php
        // Define query for latest 3 posts
        $related_posts_query = new WP_Query(array(
            'post_type' => 'blog', // Replace with your post type slug if different
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()), // Exclude the current post
        ));

        if ($related_posts_query->have_posts()):
            while ($related_posts_query->have_posts()):
                $related_posts_query->the_post();

                // Get author data
                $author_id = get_the_author_meta('ID');
                $author_avatar = get_avatar($author_id, 96);
                $post_id = get_the_ID();

                // Calculate reading time
                $reading_time = get_reading_time($post_id);
                ?>
                <div class="col-md-4 post-item">
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

                            <!-- Trim the excerpt to match dynamically loaded and main posts -->
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
            endwhile;
            wp_reset_postdata(); // Reset the query
        else: ?>
            <p><?php esc_html_e('No related posts found.', 'textdomain'); ?></p>
        <?php endif; ?>
    </div>
</div>