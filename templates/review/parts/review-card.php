<?php
/**
 * Review card.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$review_id = get_the_ID();

$rating = get_post_meta( $review_id, 'pc_review_rating', true);

$course_ids = get_post_meta( $review_id, 'pc_review_courses', true);

$teacher_ids = get_post_meta( $review_id, 'pc_review_teachers', true);
$teacher_ids = is_array( $teacher_ids ) ? $teacher_ids : array();
$course_ids  = is_array( $course_ids ) ? $course_ids : array();
?>

<article <?php post_class( 'pc-review-card' ); ?>>

 <header class="pc-review-card-header">

  <h2 class="pc-review-card-title">
   <?php the_title(); ?>
  </h2>

  <?php if ( $rating ) : ?>

   <div class="pc-review-card-rating">
    <?php for($i=0;  $i< $rating; $i++) : ?>
        <span class="star"></span>
    <?php endfor;?>
   </div>

  <?php endif; ?>

 </header>

 <div class="pc-review-card-content">

  <?php
    $content = get_the_content( null, false, $review_id );
    echo apply_filters( 'the_content', $content );
  ?>

 </div>

 <?php if ( $teacher_ids || $course_ids ) : ?>

  <footer class="pc-review-card-footer">

   <?php if ( $teacher_ids ) : ?>

    <div class="pc-review-card-teachers">

     <strong>
      <?php  esc_html_e('Teacher:','psychology-courses');  ?>
     </strong>

     <?php foreach ( $teacher_ids as $teacher_id ) : ?>

      <a href="<?php echo esc_url( get_permalink( $teacher_id ) ); ?>">
       <?php echo esc_html( get_the_title( $teacher_id ) ); ?>
      </a>

     <?php endforeach; ?>

    </div>

   <?php endif; ?>

   <?php if ( $course_ids ) : ?>

    <div class="pc-review-card-courses">

     <strong>
      <?php
      esc_html_e( 'Course:', 'psychology-courses' );
      ?>
     </strong>

     <?php foreach ( $course_ids as $course_id ) : ?>

      <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>">
       <?php echo esc_html( get_the_title( $course_id ) ); ?>
      </a>

     <?php endforeach; ?>

    </div>

   <?php endif; ?>

  </footer>

 <?php endif; ?>

</article>