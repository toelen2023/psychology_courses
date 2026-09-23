<?php
/**
 * Review meta fields.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Review_Save {

 /**
  * Register hooks.
  * @return void
  */
 public function register(): void {

  add_action( 'save_post_review', array( $this, 'save' ) );
 }

 /**
  * Save review meta.
  * @param int $post_id Review post ID.
  * @return void
  */
 public function save( $post_id ): void {

  // Nonce.
 
  if ( ! isset( $_POST['pc_review_nonce'] ) )  return;
  

  if (! wp_verify_nonce( sanitize_text_field(  wp_unslash( $_POST['pc_review_nonce'] )  ),
    'pc_review_save' ) )  return;
  // Autosave.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

  // Revision.
  if ( wp_is_post_revision( $post_id ) ) return;

  // Permissions.
  if ( ! current_user_can( 'edit_post', $post_id ) )  return;
  
  // Rating.
  if ( isset( $_POST['pc_review_rating'] ) ) {

   $rating = absint( $_POST['pc_review_rating'] );
   if ( $rating >= 1 && $rating <= 5 )  update_post_meta(  $post_id,  'pc_review_rating', $rating );
   else delete_post_meta(   $post_id,  'pc_review_rating' );

  } else   delete_post_meta(  $post_id, 'pc_review_rating' );

  // Teachers.
  $teacher_ids = array();

  if ( isset( $_POST['pc_review_teachers'] )  && is_array( $_POST['pc_review_teachers'] ) ) {

   $teacher_ids = array_map( 'absint',  wp_unslash( $_POST['pc_review_teachers'] ) );
   $teacher_ids = array_filter( $teacher_ids );
   $teacher_ids = array_values( array_unique( $teacher_ids ) );
  }

  update_post_meta( $post_id, 'pc_review_teachers',  $teacher_ids );

  // Courses.
  $course_ids = array();

  if ( isset( $_POST['pc_review_courses'] )  && is_array( $_POST['pc_review_courses'] ) ) {

   $course_ids = array_map( 'absint', wp_unslash( $_POST['pc_review_courses'] ) );
   $course_ids = array_filter( $course_ids );
   $course_ids = array_values( array_unique( $course_ids ) );
  }

  update_post_meta( $post_id, 'pc_review_courses',  $course_ids );
 }
}