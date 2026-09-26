<?php
/**
 * Review post type.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Review_Post_Type {

 /**
  * Register hooks.
  *
  * @return void
  */
 public function register(): void {

  add_action( 'init',  array( $this, 'register_post_type' )  );

 }

 /**
  * Register Review CPT.
  *
  * @return void
  */
 public function register_post_type(): void {

  $labels = array(
   'name'               => __( 'Reviews', 'psychology-courses' ), //'Отзывы'
   'singular_name'      => __( 'Review', 'psychology-courses' ),//'Отзыв',
   'add_new'            => __( 'Add Review', 'psychology-courses' ),//'Добавить отзыв',
   'add_new_item'       => __( 'Add New Review', 'psychology-courses' ),//'Добавить отзыв',
   'edit_item'          => __( 'Edit Review', 'psychology-courses' ), //'Редактировать отзыв',
   'new_item'           => __( 'New Review', 'psychology-courses' ), //'Новый отзыв',
   'view_item'          => __( 'View Review', 'psychology-courses' ),//'Просмотреть отзыв',
   'search_items'       => __( 'Search Reviews', 'psychology-courses' ), //'Искать отзывы',
   'not_found'          => __( 'No reviews found', 'psychology-courses' ), //'Отзывы не найдены',
   'not_found_in_trash' => __( 'No reviews found in Trash', 'psychology-courses' ), //'В корзине отзывов нет',
   'menu_name'          => __( 'Reviews', 'psychology-courses' ), //'Отзывы',
  );

  $args = array(
   'labels'             => $labels,
   'public'             => true,
   'publicly_queryable' => true,
   'show_ui'            => true,
   'show_in_menu'       => true,
   'menu_position'      => 25,
   'menu_icon'          => 'dashicons-star-filled',
   'supports'           => array( 'title', 'editor', ),
   'show_in_rest'       => true,
   'has_archive'        => false,
   'rewrite'            => false,
   
  );

  register_post_type( 'review', $args );
 }
}