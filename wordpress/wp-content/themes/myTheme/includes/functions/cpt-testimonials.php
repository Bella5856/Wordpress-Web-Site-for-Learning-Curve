<?php

function post_type_testimonials()
{
    $args = array(
        'labels' => array(
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('thumbnail'),
        'rewrite' => array('slug' => 'testimonials'),
    );
    register_post_type('testimonials', $args);
}
add_action('init', 'post_type_testimonials');