<?php
/**
 * Helper functions.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'pc_get_currencies' ) ) {

 /**
  * Returns supported currencies.
  *
  * @return array
  */
 function pc_get_currencies(): array {

  return array(
   'uah' => 'UAH',
   'eur' => 'EUR',
   'usd' => 'USD',
  );

 }

}

if ( ! function_exists( 'pc_get_price_meta_key' ) ) {

 /**
  * Returns meta key for course prices.
  * @return string
  */
 function pc_get_price_meta_key(): string {
  return 'pc_prices';
 }

}

if ( ! function_exists( 'pc_get_duration_meta_key' ) ) {

 /**
  * Returns meta key for course duration.
  * @return string
  */
 function pc_get_duration_meta_key(): string {
  return 'pc_duration';
 }

}

if ( ! function_exists( 'pc_get_course_teachers_meta_key' ) ) {

 /**
  * Returns meta key for teachers who can teach the course.
  * @return string
  */
 function pc_get_course_teachers_meta_key(): string {
  return 'pc_course_teachers';
 }

}

if ( ! function_exists( 'pc_get_course_prices' ) ) {

 /**
  * Returns course prices.
  * @param int $post_id Course ID.
  * @return array
  */
 function pc_get_course_prices( int $post_id ): array {

  $prices = get_post_meta(
   $post_id,
   pc_get_price_meta_key(),
   true
  );

  return is_array( $prices ) ? $prices : array();

 }

}

/**
 * Includes a template part from the plugin.
 *
 * @param string $template Relative template path.
 * @param array  $args     Variables passed to the template.
 *
 * @return void
 */
/* function pc_get_template_part( string $template, array $args = array() ): void {

 if ( ! empty( $args ) ) {
  extract( $args, EXTR_SKIP );
 }

 $file = PC_PLUGIN_DIR . 'templates/' . $template . '.php';

 if ( file_exists( $file ) ) {
  require $file;
 }

} */

 /**
 * Load a template part from the plugin.
 *
 * @param string $template Relative path to the template without .php.
 * @param array  $args     Data passed to the template.
 *
 * @return void
 */
function pc_get_template_part( string $template, array $args = array() ): void {

 $file = PC_PLUGIN_DIR . 'templates/' . $template . '.php';

 if ( ! file_exists( $file ) ) return;

 $template_args = $args;

 require $file;
}