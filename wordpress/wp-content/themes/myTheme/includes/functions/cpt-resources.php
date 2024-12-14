<?php
function post_type_free_resources()
{
    $args = array(
        'labels' => array(
            'name' => 'Free Resources',
            'singular_name' => 'Free Resource',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'resources'),
    );
    register_post_type('free_resources', $args);
}
add_action('init', 'post_type_free_resources');