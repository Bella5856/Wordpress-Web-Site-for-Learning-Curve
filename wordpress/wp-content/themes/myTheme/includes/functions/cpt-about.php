<?php

function post_type_about()
{
    $args = array(
        'labels' => array(
            'name' => 'About Us',
            'singular_name' => 'About Us',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'about-us'),
    );
    register_post_type('about_us', $args);
}
add_action('init', 'post_type_about');
