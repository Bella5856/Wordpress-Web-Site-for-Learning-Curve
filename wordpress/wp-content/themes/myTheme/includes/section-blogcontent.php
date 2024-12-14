<?php if (have_posts()):
    while (have_posts()):
        the_post(); ?>



        <div><?php the_content(); ?></div>

        <p><?php echo get_the_date('d/m/Y'); ?></p>


    <?php endwhile; else: endif; ?>