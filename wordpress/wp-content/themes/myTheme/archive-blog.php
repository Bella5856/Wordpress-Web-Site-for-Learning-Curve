<?php get_header(); ?>
<div class="display-none header-container text-center container-section">
    <br>
    <h2>Blog</h2>
    <p>Creative ideas, practical tips and insider info - Learning Curve blog </p>
</div>
<div class="container-section container  blog-wrapper">


    <div class="blog-banner bg-light py-5">

        <div class="container">
            <div class="row">
                <?php

                $latest_post_query = new WP_Query(array(
                    'posts_per_page' => 1,
                    'post_type' => 'blog',
                ));

                if ($latest_post_query->have_posts()):
                    while ($latest_post_query->have_posts()):
                        $latest_post_query->the_post();
                        ?>
                        <div class="col-md-4 content">
                            <h3><?php the_title(); ?></h3>
                            <p><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else: ?>
                    <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container container-section">
    <div class="row">
        <div class="col-md-6">
            <h4>Blog Categories</h4>
            <div id="category-filters">
                <?php
                // Fetch all blog categories
                $blog_categories = get_terms(array(
                    'taxonomy' => 'blog_category',
                    'hide_empty' => false,
                ));

                if (!empty($blog_categories) && !is_wp_error($blog_categories)):
                    foreach ($blog_categories as $category):
                        ?>
                        <label>
                            <input type="checkbox" class="filter-checkbox" data-type="category"
                                value="<?php echo esc_attr($category->slug); ?>">
                            <?php echo esc_html($category->name); ?>
                        </label>
                        <?php
                    endforeach;
                else:
                    ?>
                    <p><?php esc_html_e('No categories found.', 'textdomain'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <h4>Blog Tags</h4>
            <div id="tag-filters">
                <?php
                // Fetch all blog tags
                $blog_tags = get_terms(array(
                    'taxonomy' => 'blog_tags',
                    'hide_empty' => false,
                ));

                if (!empty($blog_tags) && !is_wp_error($blog_tags)):
                    foreach ($blog_tags as $tag):
                        ?>
                        <label>
                            <input type="checkbox" class="filter-checkbox" data-type="tag"
                                value="<?php echo esc_attr($tag->slug); ?>">
                            <?php echo esc_html($tag->name); ?>
                        </label>
                        <?php
                    endforeach;
                else:
                    ?>
                    <p><?php esc_html_e('No tags found.', 'textdomain'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php get_template_part('includes/section', 'content'); ?>


<div class="container">
    <div class="row mb-4" id="post-container">
        <!-- Existing posts will be loaded here -->
    </div>
    <div class="text-center my-4">
        <button id="load-more" class="blue-btn">Load More</button>
    </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/filter.js"></script>



<?php get_footer(); ?>