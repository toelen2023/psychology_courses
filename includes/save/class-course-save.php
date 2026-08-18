<?php
/**
 * Save Course metaboxes.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Course_Save {

 /**
  * Register hooks.
  *
  * @return void
  */
 public function register(): void {

  add_action(
   'save_post_course',
   array( $this, 'save' ),
   10,
   2
  );

 }

 /**
  * Save course.
  *
  * @param int     $post_id Post ID.
  * @param WP_Post $post    Post object.
  *
  * @return void
  */
 public function save( int $post_id, WP_Post $post ): void {

  // Nonce.
  if (
   ! isset( $_POST['pc_course_nonce'] ) ||
   ! wp_verify_nonce(
    sanitize_text_field( wp_unslash( $_POST['pc_course_nonce'] ) ),
    'pc_course_save'
   )
  ) {
   return;
  }

  // Autosave.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
   return;
  }

  // Permissions.
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
   return;
  }

  $this->save_duration( $post_id );
  $this->save_prices( $post_id );
  $this->save_teachers( $post_id );

 }

 /**
  * Save duration.
  * @param int $post_id Post ID.
  * @return void
  */
 private function save_duration( int $post_id ): void {

  if ( ! isset( $_POST['pc_duration'] ) ) return;
  
  $duration = absint( wp_unslash( $_POST['pc_duration'] ) );

  update_post_meta( $post_id, pc_get_duration_meta_key(), $duration );

 }

 /**
  * Save prices.
  * @param int $post_id Post ID.
  * @return void
  */
 private function save_prices( int $post_id ): void {

  if ( ! isset( $_POST['pc_prices'] ) ) {
   return;
  }

  $posted_prices = wp_unslash( $_POST['pc_prices'] );

  $prices = array();

  foreach ( pc_get_currencies() as $code => $label ) {

   $prices[ $code ] = array(
    'full' => isset( $posted_prices[ $code ]['full'] )
     ? floatval( $posted_prices[ $code ]['full'] )
     : '',

    'month' => isset( $posted_prices[ $code ]['month'] )
     ? floatval( $posted_prices[ $code ]['month'] )
     : '',
   );

  }

  update_post_meta( $post_id, pc_get_price_meta_key(), $prices );

 }
 /**
 * Save course teachers.
 * @param int $post_id Course ID.
 * @return void
 */
private function save_teachers( int $post_id ): void {

 $teachers = array();

 if ( isset( $_POST['pc_course_teachers'] ) ) {

  $teachers = wp_unslash( $_POST['pc_course_teachers'] );

  if ( ! is_array( $teachers ) ) $teachers = array();

 }

 $teachers = array_map(
  'absint',
  $teachers
 );

 $teachers = array_filter( $teachers );

 $teachers = array_values( array_unique( $teachers ) );

 if ( empty( $teachers ) ) {
  delete_post_meta( $post_id, pc_get_course_teachers_meta_key() );
  return;
 }

 update_post_meta( $post_id,  pc_get_course_teachers_meta_key(), $teachers  );

}

}