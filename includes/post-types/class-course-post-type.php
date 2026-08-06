<?php

namespace PsychologyCourses\PostTypes;

defined( 'ABSPATH' ) || exit;

class PC_Course_Post_Type {

    public function register(): void {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

    public function register_post_type(): void {

        $labels = [
            'name' => __( 'Courses', 'psychology-courses' ),
            'singular_name'      =>  __( 'Course', 'psychology-courses' ), // название для одной записи этого типа
			'add_new'            =>  __( 'Add Course', 'psychology-courses' ), // для добавления новой записи
			'add_new_item'       =>  __( 'Adding Course', 'psychology-courses' ), // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          =>  __( 'Edit Course', 'psychology-courses' ), // для редактирования типа записи
			'new_item'           =>  __( 'New Course', 'psychology-courses' ), // текст новой записи
			'view_item'          =>  __( 'See Course', 'psychology-courses' ), // для просмотра записи этого типа.
			'search_items'       =>  __( 'Search a Course', 'psychology-courses' ), // для поиска по этим типам записи
			'not_found'          =>  __( 'Course is not found', 'psychology-courses' ), // если в результате поиска ничего не было найдено
			'not_found_in_trash' =>  __( 'Course is not found in trash', 'psychology-courses' ), // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          =>  __( 'Courses', 'psychology-courses' ), // название меню
        ];

        register_post_type(
            'course',
            [
                'labels' => $labels,
                'public' => true,
                'publicly_queryable'  => true,
                'description' => 'Courses Page',
                'show_in_menu' => true, // показывать ли в меню админки
		        'show_in_admin_bar' => true, 
                'exclude_from_search' => false,
                'menu_position' => 21,
                'menu_icon' => 'dashicons-index-card',
                'capability_type' => 'page',
                'supports' => array("title", "editor", "author", "thumbnail", "excerpt", "custom-fields"),
                'taxonomies' => array(),
                'hierarchical' => false,
                'has_archive' => 'courses',
                'query_var' => true,
                'rewrite' => true,
                'feed' => false,

            ]
        );
    }
}