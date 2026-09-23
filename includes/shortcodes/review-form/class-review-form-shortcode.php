<?php
/**
 * Review frontend form.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Review_Form {

 /**
  * Register hooks.
  *
  * @return void
  */
 public function register(): void {

  add_shortcode('review_form', array( $this, 'render' ) );
 }

 /**
  * Render review form.
  * @return string
  */
 public function render(): string {

  $teachers = get_posts(
   array(
    'post_type'      => 'teacher',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
   )
  );

  $courses = get_posts(
   array(
    'post_type'      => 'course',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
   )
  );

  ob_start();
  ?>

  <form class="pc-review-form" method="post">

   <?php wp_nonce_field( 'pc_submit_review', 'pc_review_form_nonce' ); ?>

   <div class="pc-review-field">
    <label>
     <?php esc_html_e( 'Рейтинг', 'psychology-courses' ); ?>
     <?php for($i=1; $i<6; $i++){ ?>
        <input  type="radio" name="pc_review_rating"  value="<?php echo $i ?>" required>
    <?php } ?>
    </label>
   </div>

   <div class="pc-review-field">
    <label for="pc-review-teacher">
     <?php esc_html_e( 'Преподаватель', 'psychology-courses' ); ?>
    </label>

    <select id="pc-review-teacher" name="pc_review_teacher" required>
     <option value=""><?php esc_html_e( 'Choose a teacher', 'psychology-courses' ); ?></option>
     <?php foreach ( $teachers as $teacher ) : ?>
      <option value="<?php echo esc_attr( $teacher->ID ); ?>">
       <?php echo esc_html( get_the_title( $teacher->ID ) ); ?>
      </option>
     <?php endforeach; ?>
    </select>
   </div>

   <div class="pc-review-field">
    <label for="pc-review-course"><?php esc_html_e( 'Course', 'psychology-courses' ); ?></label>
    <select  id="pc-review-course"  name="pc_review_course" required>

     <option value=""><?php esc_html_e( 'Choose a course', 'psychology-courses' ); ?></option>

     <?php foreach ( $courses as $course ) : ?>
      <option value="<?php echo esc_attr( $course->ID ); ?>">
       <?php echo esc_html( get_the_title( $course->ID ) ); ?>
      </option>
     <?php endforeach; ?>
    </select>

   </div>

   <div class="pc-review-field">
    <label for="pc-review-content"><?php esc_html_e( 'Your review', 'psychology-courses' ); ?></label>
    <textarea id="pc-review-content"  name="pc_review_content"  rows="6" required></textarea>
   </div>

   <div class="pc-review-consent">
    <label>
     <input type="checkbox" name="pc_review_consent" value="1" required>
     <?php esc_html_e('Я согласен(на) на обработку персональных данных.', 'psychology-courses'); ?>
    </label>
   </div>

   <button  type="submit"  name="pc_review_submit"  value="1">
    <?php esc_html_e( 'Send', 'psychology-courses' ); ?>
   </button>

  </form>

  <?php
  return ob_get_clean();
 }
}