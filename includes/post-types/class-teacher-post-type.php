<?php

defined( 'ABSPATH' ) || exit;

class PC_Teacher_Post_Type {

    public function register(): void {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type(): void {

        $labels = [
            'name'                  => __( 'Teachers', 'psychology-courses' ),
            'singular_name'         => __( 'Teacher', 'psychology-courses' ),
            'add_new'               => __( 'Add Teacher', 'psychology-courses' ),
            'add_new_item'          => __( 'Add New Teacher', 'psychology-courses' ),
            'edit_item'             => __( 'Edit Teacher', 'psychology-courses' ),
            'new_item'              => __( 'New Teacher', 'psychology-courses' ),
            'view_item'             => __( 'View Teacher', 'psychology-courses' ),
            'search_items'          => __( 'Search Teachers', 'psychology-courses' ),
            'not_found'             => __( 'No teacher found', 'psychology-courses' ),
            'not_found_in_trash'    => __( 'No teacher found in Trash', 'psychology-courses' ),
            'menu_name'             => __( 'Teachers', 'psychology-courses' ),
        ];

        register_post_type(
            'teacher',
            [
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'show_in_admin_bar'  => true,
                'show_in_rest'       => true,

                'menu_position'      => 22,
                'menu_icon'          => PC_PLUGIN_URL. 'assets/img/teacher.png',

                'supports'           => [
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                ],

                'has_archive'        => 'teachers',

                'rewrite'            => [
                    'slug'       => 'teachers',
                    'with_front' => false,
                ],

                'exclude_from_search' => false,
                'hierarchical'       => false,
            ]
        );
    }
}
