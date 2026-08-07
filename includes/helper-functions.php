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
  *
  * @return string
  */
 function pc_get_price_meta_key(): string {
  return 'pc_prices';
 }

}

if ( ! function_exists( 'pc_get_duration_meta_key' ) ) {

 /**
  * Returns meta key for course duration.
  *
  * @return string
  */
 function pc_get_duration_meta_key(): string {
  return 'pc_duration';
 }

}

if ( ! function_exists( 'pc_get_course_prices' ) ) {

 /**
  * Returns course prices.
  *
  * @param int $post_id Course ID.
  *
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