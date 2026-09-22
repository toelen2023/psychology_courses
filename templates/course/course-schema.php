<?php
/**
 * Course Schema.org structured data.
 *
 * Generates JSON-LD structured data for courses
 * and course lists.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Course_Schema {

 /**
  * Build Schema.org data for one course.
  *
  * @param int $course_id Course ID.
  * @return array
  */
 public static function get_course_data( int $course_id ): array {

  $title       = get_the_title( $course_id );
  $description = get_the_excerpt( $course_id );
  $url         = get_permalink( $course_id );

  $data = array(
   '@type'       => 'Course',
   '@id'         => $url . '#course',
   'name'        => wp_strip_all_tags( $title ),
   'description' => wp_strip_all_tags( $description ),
   'url'         => $url,

   'provider' => array(
    '@type' => 'Organization',
    'name'  => 'OLVIA',
   ),
  );

  /**
   * Course featured image.
   *
   * The featured image represents the course itself.
   * The decorative course icon is intentionally not included.
   */
  $image = get_the_post_thumbnail_url(
   $course_id,
   'full'
  );

  if ( $image ) {
   $data['image'] = $image;
  }

  /**
   * Future additions:
   *
   * - hasCourseInstance
   * - instructor
   * - offers
   * - aggregateRating
   * - review
   */

  return $data;
 }


 /**
  * Output Schema.org data for one course.
  *
  * Used on the single course page.
  *
  * @param int $course_id Course ID.
  * @return void
  */
 public static function output_course( int $course_id ): void {

  $data = self::get_course_data( $course_id );

  echo '<script type="application/ld+json">';
  echo wp_json_encode(
   $data,
   JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
  );
  echo '</script>';
 }


 /**
  * Build Schema.org ItemList for courses.
  *
  * The order of $course_ids is preserved.
  *
  * @param array $course_ids Course IDs.
  * @return array
  */
 public static function get_course_list_data( array $course_ids ): array {

  $items    = array();
  $position = 1;

  foreach ( $course_ids as $course_id ) {

   $course_id = (int) $course_id;

   if ( ! $course_id ) {
    continue;
   }

   $url = get_permalink( $course_id );

   if ( ! $url ) {
    continue;
   }

   $course = self::get_course_data( $course_id );

   $items[] = array(
    '@type'    => 'ListItem',
    'position' => $position,
    'url'      => $url,
    'item'     => $course,
   );

   $position++;
  }

  return array(
   '@type'           => 'ItemList',
   'itemListElement' => $items,
  );
 }


 /**
  * Output Schema.org ItemList for courses.
  *
  * Used on course archive/list pages.
  *
  * @param array $course_ids Course IDs in display order.
  * @return void
  */
 public static function output_course_list( array $course_ids ): void {

  $data = self::get_course_list_data( $course_ids );

  /*
   * Do not output an empty ItemList.
   */
  if ( empty( $data['itemListElement'] ) ) {
   return;
  }

  echo '<script type="application/ld+json">';
  echo wp_json_encode(
   $data,
   JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
  );
  echo '</script>';
 }
}