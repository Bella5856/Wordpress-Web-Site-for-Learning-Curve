<?php get_header(); ?>

<div class="container">
    <h1><?php the_title(); ?></h1>

    <?php if (has_post_thumbnail()): ?>


        <img src="<?php the_post_thumbnail_url(); ?>" alt="img" class="img-fluid">

    <?php endif ?>
    <?php get_template_part('includes/section', 'blogcontent'); ?>
</div>

<?php get_footer(); ?>