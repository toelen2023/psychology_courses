<?php
/**
 * Review frontend form handler.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Review_Form_Handler {

 /**
  * Register hooks.
  * @return void
  */
 public function register(): void {
  add_action( 'init',  array( $this, 'handle' ) );
 }

 /**
  * Handle review submission.
  *
  * @return void
  */
 public function handle(): void {

  if ( ! isset( $_POST['pc_review_submit'] ) ) return;

  // Nonce.
  if ( ! isset( $_POST['pc_review_form_nonce'] ) ||
    ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pc_review_form_nonce'] ) ), 'pc_submit_review' )
  ) return;

  //Consent.

  if ( ! isset( $_POST['pc_review_consent'] ) || '1' !== $_POST['pc_review_consent'] ) return;

  // Rating.
  $rating = isset( $_POST['pc_review_rating'] ) ? absint( $_POST['pc_review_rating'] ) : 0;

  if ( $rating < 1 || $rating > 5 ) return;


  // Teacher.
  $teacher_id = isset( $_POST['pc_review_teacher'] ) ? absint( $_POST['pc_review_teacher'] ) : 0;

  if (! $teacher_id || 'teacher' !== get_post_type( $teacher_id )
   || 'publish' !== get_post_status( $teacher_id ) )  return;

  // Course.

  $course_id = isset( $_POST['pc_review_course'] ) ? absint( $_POST['pc_review_course'] ) : 0;

  if (! $course_id || 'course' !== get_post_type( $course_id )
   || 'publish' !== get_post_status( $course_id ) )  return;

  // Review content.
  $content = isset( $_POST['pc_review_content'] )
   ? sanitize_textarea_field( wp_unslash( $_POST['pc_review_content'] )) : '';

  if ( '' === trim( $content ) )   return;

  //Create review.
  $review_id = wp_insert_post(
   array(
    'post_type'    => 'review',
    'post_status'  => 'pending',
    'post_title'   => wp_trim_words( $content, 8, '...' ),
    'post_content' => $content,
   ),
   true
  );

  if ( is_wp_error( $review_id ) ) return;

  // Save review meta.
  update_post_meta( $review_id, 'pc_review_rating', $rating);

  update_post_meta(  $review_id,  'pc_review_teachers', array( $teacher_id ) );
  update_post_meta(  $review_id, 'pc_review_courses', array( $course_id ) );

  // Redirect after successful submission.
  $redirect_url = wp_get_referer();

  if ( ! $redirect_url ) $redirect_url = home_url( '/' );
  

  $redirect_url = add_query_arg('pc_review_submitted', '1', $redirect_url );

  wp_safe_redirect( $redirect_url );
  exit;
 }
}