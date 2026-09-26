<?php
/**
 * Review metabox.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Review_Metabox {

 /**
  * Register hooks.
  * @return void
  */
 public function register(): void {

  add_action( 'add_meta_boxes_review', array( $this, 'add_meta_box' ));

  add_filter( 'manage_review_posts_columns', array( $this, 'add_review_columns' ) );

  add_action( 'manage_review_posts_custom_column',
   array( $this, 'render_review_columns' ),  10, 2 );
 }

 /**
  * Add review metabox.
  *
  * @return void
  */
 public function add_meta_box(): void {

  add_meta_box(
   'pc-review-details', __( 'Review Parameters', 'psychology-courses' ), //Параметры отзыва
   array( $this, 'render' ),
   'review',
   'side',
   'high'
  );
 }

 /**
  * Render metabox.
  * @param WP_Post $post Current post.
  * @return void
  */
 public function render( $post ): void {

  wp_nonce_field('pc_review_save', 'pc_review_nonce' );

  $rating = get_post_meta( $post->ID, 'pc_review_rating',  true);
  $rating = "" === $rating ? 5: $rating;

  $teacher_ids = get_post_meta( $post->ID, 'pc_review_teachers', true );

  $course_ids = get_post_meta( $post->ID, 'pc_review_courses', true );

  $teacher_ids = is_array( $teacher_ids ) ? $teacher_ids : array();
  $course_ids  = is_array( $course_ids ) ? $course_ids : array();

  $teachers = get_posts(
   array(
    'post_type'      => 'teacher',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
   ) );

  $courses = get_posts(
      array(
    'post_type'      => 'course',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
   ) );
  ?>

  <div class="pc-review-metabox">

   <p> <b><?php esc_html_e( 'Рейтинг', 'psychology-courses' ); ?></b> </p>

   <p>
    <input type="number"  name="pc_review_rating" id="pc_review_rating"
     value="<?php echo esc_attr( $rating ); ?>"
     min="1"  max="5"  step="1"  required>
   </p>

   <hr>
   <p><b><?php esc_html_e( 'Преподаватели', 'psychology-courses' ); ?></b></p>

   <?php if ( $teachers ) : ?>

    <?php foreach ( $teachers as $teacher ) : ?>

     <label style="display: block; margin-bottom: 6px;">

      <input type="checkbox" name="pc_review_teachers[]"
       value="<?php echo esc_attr( $teacher->ID ); ?>"
       <?php checked( in_array( $teacher->ID, $teacher_ids, true ) ); ?>>

      <?php echo esc_html( get_the_title( $teacher->ID ) ); ?>

     </label>

    <?php endforeach; ?>

   <?php else : ?>

    <p><?php esc_html_e( 'Teachers not found.', 'psychology-courses' ); ?></p>

   <?php endif; ?>

   <hr>

   <p><b><?php esc_html_e( 'Courses', 'psychology-courses' ); ?></b></p>

   <?php if ( $courses ) : ?>

    <?php foreach ( $courses as $course ) : ?>

     <label style="display: block; margin-bottom: 6px;">

      <input type="checkbox"  name="pc_review_courses[]"
       value="<?php echo esc_attr( $course->ID ); ?>"
       <?php checked( in_array( $course->ID, $course_ids, true ) ); ?>>

      <?php echo esc_html( get_the_title( $course->ID ) ); ?>

     </label>

    <?php endforeach; ?>

   <?php else : ?>

    <p><?php esc_html_e( 'Courses not found', 'psychology-courses' ); ?></p>

   <?php endif; ?>

  </div>

  <?php
 }

  /**
  * Add custom columns to reviews list.
  *
  * @param array $columns Existing columns.
  *
  * @return array
  */
 public function add_review_columns( $columns ): array {

  $new_columns = array();

  foreach ( $columns as $key => $label ) {
   $new_columns[ $key ] = $label;

   if ( 'title' === $key ) {
    $new_columns['pc_review_teacher'] = __( 'Teacher','psychology-courses' );
    $new_columns['pc_review_course'] = __('Course',  'psychology-courses' );
    $new_columns['pc_review_rating'] = __( 'Rating',  'psychology-courses');
   }
  }

  return $new_columns;
 }

 /**
  * Render custom review columns.
  *
  * @param string $column  Column name.
  * @param int    $post_id Review ID.
  *
  * @return void
  */
 public function render_review_columns( $column, $post_id ): void {

  switch ( $column ) {

   case 'pc_review_teacher':

    $teacher_ids = get_post_meta( $post_id, 'pc_review_teachers', true );

    $teacher_ids = is_array( $teacher_ids ) ? $teacher_ids : array();

    $teacher_names = array();

    foreach ( $teacher_ids as $teacher_id ) {
     $name = get_the_title( $teacher_id );
     if ( $name ) $teacher_names[] = $name;    
    }

    echo esc_html( implode( ', ', $teacher_names ) );

    break;

   case 'pc_review_course':

    $course_ids = get_post_meta( $post_id,'pc_review_courses', true );

    $course_ids = is_array( $course_ids ) ? $course_ids: array();

    $course_names = array();

    foreach ( $course_ids as $course_id ) {
     $name = get_the_title( $course_id );
     if ( $name )  $course_names[] = $name;  
    }

    echo esc_html( implode( ', ', $course_names ));

    break;

   case 'pc_review_rating':

    $rating = get_post_meta( $post_id, 'pc_review_rating', true);

    if ( '' !== $rating ) echo esc_html( $rating . '/5' );
    break;
  }
 }
}