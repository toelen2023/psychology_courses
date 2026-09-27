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

<div class="pc-review-card d-flex-column">

 <header class="pc-review-card-header d-flex-between">
   <div class="pc-review-card__name-group text-bold">
      <span class="pc-review-initials"><?php echo mb_strtoupper(mb_substr(get_the_title(),0, 1, 'UTF-8'), 'UTF-8'); ?></span>
      <span><?php the_title(); ?></span>
	 </div>

  <?php if ( $rating ) : ?>
   <div class="pc-review-card-rating">
    <?php for($i=0;  $i< 5; $i++) { ?>
        <span class="<?php echo $i< $rating ? "star": "star-gray" ?>"></span>
    <?php } ?>
   </div>
  <?php endif; ?>
 </header>

 <div class="pc-review-card-content d-flex-between">
    <div class="pc-review-card__quotes"> ❝ </div>
    <div class="pc-review-card__text">
      <?php
        $content = get_the_content( null, false, $review_id );
        echo apply_filters( 'the_content', $content );
      ?>
    </div>
 </div>

 <?php if ( $teacher_ids || $course_ids ) : ?>

  <footer class="pc-review-card-footer flex-to-bottom text-right">

   <?php if ( $teacher_ids ) : ?>

    <div class="pc-review-card-teachers">
     <?php  esc_html_e('Teacher:','psychology-courses'); ?>

     <?php foreach ( $teacher_ids as $teacher_id ) : ?>
      <a href="<?php echo esc_url( get_permalink( $teacher_id ) ); ?>" class="no-decoration">
       <?php echo esc_html( get_the_title( $teacher_id ) ); ?>
      </a>
     <?php endforeach; ?>
    </div>

   <?php endif; ?>

   <?php if ( $course_ids ) : ?>

    <div class="pc-review-card-courses text-bold">
     <?php foreach ( $course_ids as $course_id ) : ?>
      <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="no-decoration">
       <?php echo esc_html( get_the_title( $course_id ) ); ?>
      </a>
     <?php endforeach; ?>
    </div>
   <?php endif; ?>
  </footer>
 <?php endif; ?>
</div>