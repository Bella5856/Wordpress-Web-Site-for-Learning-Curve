<?php

function post_type_faq()
{
    $args = array(
        'labels' => array(
            'name' => 'FAQs',
            'singular_name' => 'FAQ',
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'faqs'),
    );
    register_post_type('faq', $args);
}
add_action('init', 'post_type_faq');