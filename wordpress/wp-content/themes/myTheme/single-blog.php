<?php get_header(); ?>

<?php if (has_post_thumbnail()): ?>
    <div class="blog-post-banner" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
    </div>
<?php endif; ?>

<div class="blog-content-section content-section container-section">
    <h1><?php the_title(); ?></h1>
    <p class="text-center mb-5">
        <span><?php echo get_the_author_meta('display_name', get_post_field('post_author', get_the_ID())); ?></span>
        <span><?php echo get_the_date(); ?></span>
        <span><?php echo get_reading_time(get_the_ID()); ?> min read</span>
    </p>

    <?php get_template_part('includes/section', 'blogcontent'); ?>
</div>

<div class="container mt-5">
    <h2>Latest Blog Posts</h2>
</div>
<?php get_template_part('includes/section', 'blogpagecontent'); ?>


<div class="container">
    <div class="row mb-4" id="post-container">

    </div>
    <div class="text-center my-4">
        <button id="load-more" class="btn btn-primary">Load More</button>
    </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/filter.js"></script>

<?php get_footer(); ?>