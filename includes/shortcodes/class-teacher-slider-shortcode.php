<?php
/**
 * Teacher slider shortcode.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Teacher_Slider_Shortcode {

 /**
  * Register shortcode.
  *
  * @return void
  */
 public function register(): void {

  add_shortcode( 'pc_teacher_slider', array( $this, 'render' ) );

 }

 /**
  * Render teacher slider.
  * @param array|string $atts Shortcode attributes.
  * @return string
  */
 public function render( $atts ): string {

  $atts = shortcode_atts(
   array(
    'ids' => '',
   ),
   $atts,
   'pc_teacher_slider'
  );
  print_r($atts['ids']);
  if ( empty( $atts['ids'] ) )  return '';


  $teacher_ids = array_map('absint', explode( ',', $atts['ids'] ) );

  $teacher_ids = array_filter( $teacher_ids );

  if ( empty( $teacher_ids ) )  return '';
  

  ob_start();

  pc_get_template_part(
   'teacher/parts/teacher-slider',
   array(
    'teacher_ids' => $teacher_ids,
   )
  );

  return ob_get_clean();
 }
}