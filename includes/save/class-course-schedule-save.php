<?php

/**
 * Save Course Schedule data.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Course_Schedule_Save {

 /**
  * Register save hook.
  * @return void
  */
 public function register(): void {
  add_action( 'save_post_course-stream', array( $this, 'save' ) );
 }

 /**
  * Save schedule rows.
  *
  * @param int $post_id Post ID.
  * @return void
  */
 public function save( int $post_id ): void {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  return;
  

  if (! isset( $_POST['pc_schedule_nonce'] )
        || ! wp_verify_nonce( sanitize_text_field(
     wp_unslash( $_POST['pc_schedule_nonce'] )), 'pc_schedule_save'))  return;
  

  if ( ! current_user_can( 'edit_post', $post_id ) ) return;
  

  $rows = array();

  if ( isset( $_POST['pc_schedule_rows'] ) ) {
   $posted_rows = wp_unslash( $_POST['pc_schedule_rows'] );

   if ( is_array( $posted_rows ) ) $rows = $this->sanitize_rows( $posted_rows );
   
  }

  if ( empty( $rows ) ) {
   delete_post_meta( $post_id, 'pc_schedule_rows');
   return;
  }

  update_post_meta( $post_id, 'pc_schedule_rows', $rows );
 }

 /**
  * Sanitize schedule rows.
  * @param array $posted_rows Posted rows.
  * @return array
  */
 private function sanitize_rows( array $posted_rows ): array {

  $rows = array();

  foreach ( $posted_rows as $row ) {

   if ( ! is_array( $row ) )  continue;
   

   $course_id = isset( $row['course_id'] ) ? absint( $row['course_id'] )  : 0;

   $teacher_id = isset( $row['teacher_id'] )  ? absint( $row['teacher_id'] ) : 0;

   $course_name = $course_id ? get_the_title( $course_id ) : '';

   $teacher_name = $teacher_id ? get_the_title( $teacher_id )  : '';

   $stream = isset( $row['stream'] ) ? absint( $row['stream'] ) : 0;

   $date = isset( $row['date'] ) ? sanitize_text_field( $row['date'] ) : '';

   $time = isset( $row['time'] ) ? sanitize_text_field( $row['time'] ) : '';

   $duration = isset( $row['duration'] )  ? absint( $row['duration'] )  : 0;

   $lessons = isset( $row['lessons'] ) ? absint( $row['lessons'] ) : 0;

   $icon_class = isset( $row['icon_class'] ) ? sanitize_html_class( $row['icon_class'] ) : '';

   $registration = isset( $row['registration'] )? sanitize_textarea_field( $row['registration'] )
    : '';

   // Ignore completely empty rows.
    
   if ( 0 === $course_id
        && 0 === $teacher_id
        && 0 === $stream
        && '' === $date
        && '' === $time
        && 0 === $duration
        && 0 === $lessons
        && '' === $icon_class
        && '' === $registration  )  continue;
   

   $rows[] = array(
    'course_id'    => $course_id,
    'course_name'  => $course_name,
    'stream'       => $stream,
    'date'         => $date,
    'time'         => $time,
    'duration'     => $duration,
    'lessons'      => $lessons,
    'teacher_id'   => $teacher_id,
    'teacher_name' => $teacher_name,
    'icon_class'   => $icon_class,
    'registration' => $registration,
   );
  }

  return $rows;
 }
}