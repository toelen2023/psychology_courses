<?php
/**
 * Frontend assets.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Assets {

 /**
  * Register hooks.
  *
  * @return void
  */
 public function register(): void {

  add_action('wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );

 }

 /**
  * Enqueue frontend styles.
  *
  * @return void
  */
 public function enqueue_frontend_styles(): void {

  if ( ! is_singular( array( 'course', 'teacher' ) )
   && ! is_post_type_archive( array( 'course', 'teacher' ) ) )  return;

  wp_enqueue_style(
   'pc-swiper', PC_PLUGIN_URL . 'assets/css/swiper-bundle.min.css',
   array(), PC_VERSION );
  wp_enqueue_style(
   'pc-frontend', PC_PLUGIN_URL . 'assets/css/psy_courses.css',
   array('pc-swiper'), PC_VERSION );
   wp_enqueue_script(
   'pc-swiper-script', PC_PLUGIN_URL . 'assets/js/swiper-bundle.min.js',
   array(), PC_VERSION, true );
   wp_enqueue_script(
   'pc-main', PC_PLUGIN_URL . 'assets/js/psy_courses.js',
   array('pc-swiper-script'), PC_VERSION, true );
}

}