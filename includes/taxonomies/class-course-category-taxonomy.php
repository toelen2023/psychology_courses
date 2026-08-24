<?php
/**
 * Register Course Category taxonomy.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Course_Category_Taxonomy {

 /**
  * Register hooks.
  *
  * @return void
  */
 public function register(): void {
  add_action( 'init', array( $this, 'register_taxonomy' ) );
 }

 /**
  * Register taxonomy.
  *
  * @return void
  */
 public function register_taxonomy(): void {

  $labels = array(
   'name'              => __( 'Course Categories', 'psychology-courses' ),
   'singular_name'     => __( 'Course Category', 'psychology-courses' ),
   'search_items'      => __( 'Search Categories', 'psychology-courses' ),
   'all_items'         => __( 'All Categories', 'psychology-courses' ),
   'parent_item'       => __( 'Parent Category', 'psychology-courses' ),
   'parent_item_colon' => __( 'Parent Category:', 'psychology-courses' ),
   'edit_item'         => __( 'Edit Category', 'psychology-courses' ),
   'update_item'       => __( 'Update Category', 'psychology-courses' ),
   'add_new_item'      => __( 'Add New Category', 'psychology-courses' ),
   'new_item_name'     => __( 'New Category Name', 'psychology-courses' ),
   'menu_name'         => __( 'Categories', 'psychology-courses' ),
  );

  $args = array(

   'labels' => $labels,

   'public'             => true,
   'show_ui'            => true,
   'show_admin_column'  => true,
   'show_in_nav_menus'  => false,
   'show_tagcloud'      => false,
   'show_in_rest'       => true,

   'hierarchical' => true,

   'rewrite' => array(
    'slug'         => 'course-category',
    'with_front'   => false,
    'hierarchical' => true,
   ),

  );

  register_taxonomy(
   'course_category',
   array( 'course' ),
   $args
  );

 }

}