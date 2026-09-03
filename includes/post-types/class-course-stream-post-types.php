<?php
/**
 * Stream post type.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'PC_Stream_Post_Type' ) ) {

 // Registers Stream post type.

 class PC_Course_Stream_Post_Type {

  /**
   * Post type name.
   * @var string
   */
  public const POST_TYPE = 'course-stream';

  public function register(): void {
        add_action( 'init', [ $this, 'register_post_type' ] );
    }

  public function register_post_type(): void {

   $labels = array(
    'name'               => __( 'Потоки', 'psychology-courses' ),
    'singular_name'      => __( 'Потік', 'psychology-courses' ),
    'add_new'            => __( 'Додати потік', 'psychology-courses' ),
    'add_new_item'       => __( 'Додати новий потік', 'psychology-courses' ),
    'edit_item'          => __( 'Редагувати потік', 'psychology-courses' ),
    'new_item'           => __( 'Новий потік', 'psychology-courses' ),
    'view_item'          => __( 'Переглянути потік', 'psychology-courses' ),
    'search_items'       => __( 'Пошук потоків', 'psychology-courses' ),
    'not_found'          => __( 'Потоків не знайдено', 'psychology-courses' ),
    'not_found_in_trash' => __( 'У кошику потоків не знайдено', 'psychology-courses' ),
    'menu_name'          => __( 'Потоки', 'psychology-courses' ),
   );

   $args = array(
    'labels'             => $labels,
    'public'             => false,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'show_in_rest'       => true,
    'has_archive'        => false,
    'rewrite'            => false,
    'menu_icon'          => 'dashicons-calendar-alt',
    'supports'           => array( 'title' ),
   );

   register_post_type(
    self::POST_TYPE,
    $args
   );

  }
 }
}