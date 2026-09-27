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
 // add_action( 'init',  array( $this, 'handle' ) );
  add_action( 'wp_ajax_add_review',  array( $this, 'handle' ) );

  add_action( 'wp_ajax_nopriv_add_review', array( $this, 'handle' ) );
 }


 /**
  * Handle review submission.
  *
  * @return void
  */
 public function handle(): void {

 // if ( ! isset( $_POST['pc_review_submit'] ) ) return;

  // Nonce.
  if ( ! isset( $_POST['pc_review_form_nonce'] ) ||
    ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pc_review_form_nonce'] ) ), 'pc_submit_review' )
  )   wp_send_json_error( array('message' => $this->get_error_message(),));


  //Consent.

  if ( ! isset( $_POST['pc_review_consent'] ) || '1' !== $_POST['pc_review_consent'] ) wp_send_json_error(
    array('message' => $this->get_error_message(),) );

  // Rating.
  $rating = isset( $_POST['pc_review_rating'] ) ? absint( $_POST['pc_review_rating'] ) : 0;

  if ( $rating < 1 || $rating > 5 ) wp_send_json_error( array( 'message' => $this->get_error_message(),));

  // Teacher.
  $teacher_id = isset( $_POST['pc_review_teacher'] ) ? absint( $_POST['pc_review_teacher'] ) : 0;

  if (! $teacher_id || 'teacher' !== get_post_type( $teacher_id )
   || 'publish' !== get_post_status( $teacher_id ) )  return;

  // Course.

  $course_id = isset( $_POST['pc_review_course'] ) ? absint( $_POST['pc_review_course'] ) : 0;

  if (! $course_id || 'course' !== get_post_type( $course_id ) || 'publish' !== get_post_status( $course_id ) ) 
    wp_send_json_error( array('message' => $this->get_error_message(),));

  // Review content.
  $content = isset( $_POST['pc_review_content'] )
   ? sanitize_textarea_field( wp_unslash( $_POST['pc_review_content'] )) : '';

  if ( '' === trim( $content ) ) wp_send_json_error(array( 'message' => $this->get_error_message(), ));
   //Author name.
  $author_name = isset( $_POST['review-author'] ) ? sanitize_text_field( wp_unslash( $_POST['review-author'] )) : '';

  if ( '' === trim( $author_name ) ) wp_send_json_error( array( 'message' => $this->get_error_message(), ) );

  //Create review.
  $review_id = wp_insert_post(
   array(
    'post_type'    => 'review',
    'post_status'  => 'pending',
    'post_title'   => $author_name,
    'post_content' => $content,
   ),  true );

  if ( is_wp_error( $review_id ) )  wp_send_json_error( array('message' => $this->get_error_message(), ) ); 

  // Save review meta.
  update_post_meta( $review_id, 'pc_review_rating', $rating);
  update_post_meta( $review_id,  'pc_review_teachers', array( $teacher_id ) );
  update_post_meta( $review_id, 'pc_review_courses', array( $course_id ) );

   // Success.
  wp_send_json_success( array( 'message' => $this->get_success_message(), ));
 }
  /**
  * Get success message from form.
  * @return string
  */
 private function get_success_message(): string {

  if ( isset( $_POST['success_message'] ) )  return sanitize_text_field( wp_unslash( $_POST['success_message'] ) );
  return __( 'Thanks for your review!', 'psychology-courses' );
 }

 /** Get error message from form.
  * @return string
  */
 private function get_error_message(): string {

  if ( isset( $_POST['error_message'] ) ) return sanitize_text_field( wp_unslash( $_POST['error_message'] ) );
  return __( 'Sorry. An error occurred.', 'psychology-courses' );
 }
}
