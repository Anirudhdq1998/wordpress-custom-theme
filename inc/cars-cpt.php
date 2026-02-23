<?php
if (!defined('ABSPATH')) exit;

// 1. Register Cars CPT
function create_cars_cpt() {
    register_post_type('cars',
        array(
            'labels' => array(
                'name'                  => __('Cars'),
                'singular_name'         => __('Car'),
                'add_new'               => __('Add New Car'),
                'add_new_item'          => __('Add New Car'),
                'edit_item'             => __('Edit Car'),
                'new_item'              => __('New Car'),
                'view_item'             => __('View Car'),
                'search_items'          => __('Search Cars'),
                'not_found'             => __('No Cars found'),
                'not_found_in_trash'    => __('No Cars found in trash')
            ),
            'public'            => true,
            'has_archive'       => true,
            'rewrite'           => array('slug' => 'cars'),
            'supports'          => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'      => true,
            'menu_icon'         => 'dashicons-car',
            'taxonomies'        => array('category', 'post_tag'),
            'show_in_menu'      => true,
            'menu_position'     => 5,
            'publicly_queryable'=> true
        )
    );
}
add_action('init', 'create_cars_cpt', 0);

// 2. Show cars in category/tag archives
add_filter('pre_get_posts', 'cars_in_category_archives');
function cars_in_category_archives($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_category() || is_tag()) {
            $query->set('post_type', array('post', 'cars'));
        }
    }
}