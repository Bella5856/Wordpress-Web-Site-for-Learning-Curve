<?php

function post_type_blog()
{
    $args = array(
        'labels' => array(
            'name' => 'Blog',
            'singular_name' => 'Blog',
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'blog'),
    );
    register_post_type('blog', $args);
}
add_action('init', 'post_type_blog');

function blogs_taxonomy()
{
    $args = array(
        'labels' => array(
            'name' => 'Blog Categories',
            'singular_name' => 'Blog Category',
        ),
        'public' => true,
        'hierarchical' => true,
    );
    register_taxonomy('blog_category', array('blog'), $args);
}
add_action('init', 'blogs_taxonomy');

function blogs_taxonomy_tags()
{
    $args = array(
        'labels' => array(
            'name' => 'Blog Tags',
            'singular_name' => 'Blog Tag',
        ),
        'public' => true,
        'hierarchical' => false,
    );
    register_taxonomy('blog_tags', array('blog'), $args);
}
add_action('init', 'blogs_taxonomy_tags');