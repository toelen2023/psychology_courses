<?php

defined( 'ABSPATH' ) || exit;

class PC_Course_Post_Type {

    public function register(): void {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type(): void {

        $labels = [
            'name'                  => __( 'Courses', 'psychology-courses' ),
            'singular_name'         => __( 'Course', 'psychology-courses' ),
            'add_new'               => __( 'Add Course', 'psychology-courses' ),
            'add_new_item'          => __( 'Add New Course', 'psychology-courses' ),
            'edit_item'             => __( 'Edit Course', 'psychology-courses' ),
            'new_item'              => __( 'New Course', 'psychology-courses' ),
            'view_item'             => __( 'View Course', 'psychology-courses' ),
            'search_items'          => __( 'Search Courses', 'psychology-courses' ),
            'not_found'             => __( 'No courses found', 'psychology-courses' ),
            'not_found_in_trash'    => __( 'No courses found in Trash', 'psychology-courses' ),
            'menu_name'             => __( 'Courses', 'psychology-courses' ),
        ];

        register_post_type(
            'course',
            [
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'show_in_admin_bar'  => true,
                'show_in_rest'       => true,

                'menu_position'      => 21,
                'menu_icon'          => 'dashicons-index-card',

                'supports'           => [
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                ],

                'has_archive'        => 'courses',

                'rewrite'            => [
                    'slug'       => 'courses',
                    'with_front' => false,
                ],

                'exclude_from_search' => false,
                'hierarchical'       => false,
            ]
        );
    }
}
