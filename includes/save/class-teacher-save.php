<?php
/**
 * Save teacher metaboxes.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Teacher_Save {

 /**
  * Register save hook.
  * @return void
  */
 public function register(): void {

  add_action(
   'save_post_teacher',
   array( $this, 'save' )
  );

 }

 /**
  * Save teacher data.
  *
  * @param int $post_id Teacher post ID.
  *
  * @return void
  */
 public function save( int $post_id ): void {

  /*
   * Do not save during autosave.
   */
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
   return;
  }

  /*
   * Check user permissions.
   */
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
   return;
  }

  /*
   * Check nonce.
   */
  if (
   ! isset( $_POST['pc_teacher_courses_nonce'] )
   || ! wp_verify_nonce(
    sanitize_text_field(
     wp_unslash(
      $_POST['pc_teacher_courses_nonce']
     )
    ),
    'pc_teacher_courses'
   )
  ) {
   return;
  }

  /*
   * Save courses assigned to this teacher.
   */
  $this->save_courses( $post_id );

 }

 /**
  * Save courses assigned to the teacher.
  *
  * The relationship is stored in the course meta field
  * pc_course_teachers.
  *
  * @param int $teacher_id Teacher post ID.
  *
  * @return void
  */
 private function save_courses( int $teacher_id ): void {

  $selected_courses = array();

  /*
   * Get selected courses from the metabox.
   */
  if ( isset( $_POST['pc_teacher_courses'] ) ) {

   $selected_courses = wp_unslash(
    $_POST['pc_teacher_courses']
   );

   if ( ! is_array( $selected_courses ) ) {
    $selected_courses = array();
   }

  }

  /*
   * Sanitize course IDs.
   */
  $selected_courses = array_map(
   'absint',
   $selected_courses
  );

  $selected_courses = array_filter(
   $selected_courses
  );

  $selected_courses = array_values(
   array_unique(
    $selected_courses
   )
  );

  /*
   * Get all courses.
   *
   * We need to check every course because
   * unchecking a course also has to remove
   * the teacher from that course.
   */
  $courses = get_posts(
   array(
    'post_type'      => 'course',
    'post_status'    => array(
     'publish',
     'draft',
     'pending',
     'private',
    ),
    'posts_per_page' => -1,
    'fields'         => 'ids',
   )
  );

  /*
   * Update the teacher relationship
   * in every course.
   */
  foreach ( $courses as $course_id ) {

   $teachers = get_post_meta(
    $course_id,
    pc_get_course_teachers_meta_key(),
    true
   );

   /*
    * Make sure we have an array.
    */
   if ( ! is_array( $teachers ) ) {
    $teachers = array();
   }

   /*
    * Sanitize existing teacher IDs.
    */
   $teachers = array_map(
    'absint',
    $teachers
   );

   $teachers = array_filter(
    $teachers
   );

   $teachers = array_values(
    array_unique(
     $teachers
    )
   );

   /*
    * Is this course selected for the teacher?
    */
   $is_selected = in_array(
    $course_id,
    $selected_courses,
    true
   );

   /*
    * Is the teacher already assigned to the course?
    */
   $has_teacher = in_array(
    $teacher_id,
    $teachers,
    true
   );

   /*
    * Checkbox checked:
    * add teacher to the course.
    */
   if ( $is_selected && ! $has_teacher ) {

    $teachers[] = $teacher_id;

   }

   /*
    * Checkbox unchecked:
    * remove teacher from the course.
    */
   if ( ! $is_selected && $has_teacher ) {

    $teachers = array_diff(
     $teachers,
     array( $teacher_id )
    );

   }

   /*
    * Clean the resulting array.
    */
   $teachers = array_map(
    'absint',
    $teachers
   );

   $teachers = array_filter(
    $teachers
   );

   $teachers = array_values(
    array_unique(
     $teachers
    )
   );

   /*
    * Save or delete the meta field.
    */
   if ( empty( $teachers ) ) {

    delete_post_meta(
     $course_id,
     pc_get_course_teachers_meta_key()
    );

   } else {

    update_post_meta(
     $course_id,
     pc_get_course_teachers_meta_key(),
     $teachers
    );

   }

  }

 }

}