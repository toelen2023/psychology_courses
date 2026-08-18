<?php
/**
 * Teacher metaboxes.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Teacher_Metabox {

 /**
  * Register hooks.
  * @return void
  */
 public function register(): void {

  add_action(
   'add_meta_boxes',
   array( $this, 'add_meta_boxes' )
  );

 }

 /**
  * Register metaboxes.
  * @return void
  */
 public function add_meta_boxes(): void {

  /* add_meta_box(
   'pc_teacher_consult_price',
   __( 'Teacher Consultation Price', 'psychology-courses' ),
   array( $this, 'render_teacher_consult_price' ),
   'teacher',
   'side',
   'default'
  ); */

   add_meta_box(
    'pc_teacher_courses',
    __( 'Courses', 'psychology-courses' ),
    array( $this, 'render_courses' ),
    'teacher',
    'side',
    'default'
    );

 }
/**
 * Render courses metabox.
 * @param WP_Post $post Current teacher post.
 * @return void
 */
public function render_courses( WP_Post $post ): void {

    $teacher_id = $post->ID;

    $courses = get_posts(
    array(
        'post_type'      => 'course',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        )
    );

    if ( empty( $courses ) ) {
        esc_html_e('No courses available.', 'psychology-courses');
        return;
    }

    wp_nonce_field(
        'pc_teacher_courses',
        'pc_teacher_courses_nonce'   );

    foreach ( $courses as $course ) {

    $teachers = get_post_meta(
        $course->ID,
        pc_get_course_teachers_meta_key(),
        true
    );

    if ( ! is_array( $teachers ) )  $teachers = array();

    ?>

    <p>

    <label>

        <input
        type="checkbox"
        name="pc_teacher_courses[]"
        value="<?php echo esc_attr( $course->ID ); ?>"
        <?php checked( in_array( $teacher_id, $teachers, true ) ); ?>
        >

        <?php echo esc_html( $course->post_title ); ?>

    </label>

    </p>

    <?php
    }
  }

}//end class