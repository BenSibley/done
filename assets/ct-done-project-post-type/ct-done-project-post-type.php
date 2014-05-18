<?php
/*
Plugin Name: Done Project Post Type
Description: Adds project post type used in portfolio
Author: Compete Themes
Version: 1.0
*/

add_action( 'init', 'compete_themes_create_project_post_type' );
function compete_themes_create_project_post_type() {
    register_post_type( 'done_project',
        array(
            'labels' => array(
                'name' => __( 'Projects' ),
                'singular_name' => __( 'Project' ),
                'add_new_item' => __('Add New Project'),
                'edit_item' => __('Edit Project'),
                'new_item' => __('New Project'),
                'view_item' => __('View Project'),
                'search_item' => __('Search Projects'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'author',
                'thumbnail'
            ),
            'rewrite' => array(
                'slug' => 'project'
            )
        )
    );
}

// create the taxonomy/categories for Projects
add_action( 'init', 'compete_themes_create_project_post_taxonomy', 0 );

function compete_themes_create_project_post_taxonomy() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => _x( 'Categories', 'categories' ),
        'singular_name'     => _x( 'Category', 'category' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Category' )
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'project-category' ),
    );

    register_taxonomy( 'done_project_category', array( 'done_project' ), $args );
}
