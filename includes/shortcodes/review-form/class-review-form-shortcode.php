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
  <h3><?php _e( 'Add review', 'psychology-courses' ); ?></h3>
  <form class="pc-review-form" method="post">

   <?php wp_nonce_field( 'pc_submit_review', 'pc_review_form_nonce' ); ?>
   <label><?php _e( 'Rating', 'psychology-courses' ); ?>
    <div class="pc-rating__group">
        <input class="rating__star" type="radio" name="pc_review_rating" value="1" aria-label="Ужасно">
        <input class="rating__star" type="radio" name="pc_review_rating" value="2" aria-label="Сносно">
        <input class="rating__star" type="radio" name="pc_review_rating" value="3" aria-label="Нормально">
        <input class="rating__star" type="radio" name="pc_review_rating" value="4" aria-label="Хорошо">
        <input class="rating__star" type="radio" name="pc_review_rating" value="5" aria-label="Отлично" checked="">
    </div>
  </label>
   <div class="d-flex-between gap=20">
    <div class="column-1-3">  
      <input type="text" name="review-author" class="w-100" placeholder="<?php _e( 'Your name', 'psychology-courses' ) ?>" required>

      <select id="pc-review-teacher" name="pc_review_teacher" class="w-100" required>
       <option value=""><?php esc_html_e( 'Choose a teacher', 'psychology-courses' ); ?></option>
       <?php foreach ( $teachers as $teacher ) : ?>
        <option value="<?php echo esc_attr( $teacher->ID ); ?>">
         <?php echo esc_html( get_the_title( $teacher->ID ) ); ?>
        </option>
       <?php endforeach; ?>
      </select>
      <select  id="pc-review-course"  name="pc_review_course" class="w-100" required>
       <option value=""><?php esc_html_e( 'Choose a course', 'psychology-courses' ); ?></option>
       <?php foreach ( $courses as $course ) : ?>
        <option value="<?php echo esc_attr( $course->ID ); ?>">
         <?php echo esc_html( get_the_title( $course->ID ) ); ?>
        </option>
       <?php endforeach; ?>
      </select>
     </div>
   <div class="column-2-3">
    <textarea id="pc-review-content" name="pc_review_content" class="w-100" rows="6" placeholder="<?php esc_html_e( 'Your review', 'psychology-courses' ); ?>" required></textarea>
  </div>
  </div>
  <div class="pc-review-consent">
    <label>

     <input type="checkbox" name="pc_review_consent" value="1" required>
     <?php esc_html_e('I consent to the processing of my personal data in accordance with the Law of Ukraine No. 2297-VI dated June 1, 2010, "On Personal Data Protection."', 'psychology-courses'); ?>
    </label>
   </div>  
   <input type="hidden" name="success-message" id="success-message" value="<?php _e( 'Thanks for your review!', 'psychology-courses' ); ?>">
   <input type="hidden" name="action" value="add_review">
   <!-- Дякуємо за ваш відгук! -->
    <input type="hidden" name="error-message" id="error-message" value="<?php _e( 'Sorry. An error occurred.', 'psychology-courses' ); ?>">
    <!-- Вибачте. Сталася помилка. -->
   <button  type="submit"  name="pc_review_submit"  value="1" class="center-button my-30">
    <?php esc_html_e( 'Send review', 'psychology-courses' ); ?>
   </button>
  </form>

  <?php
  return ob_get_clean();
 }
}