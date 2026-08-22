<?php
/**
 * Teacher slider.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_ids = $template_args['teacher_ids'] ?? array();

$teachers = new WP_Query(
 array(
  'post_type'      => 'teacher',
  'post_status'    => 'publish',
  'post__in'       => $teacher_ids,
  'orderby'        => 'post__in',
  'posts_per_page' => -1,
 )
);


if ( ! $teachers->have_posts() ) return;

?>

<section class="pc-teacher-slider">

 <div class="swiper pc-teacher-slider-swiper">

  <div class="swiper-wrapper">

   <?php while ( $teachers->have_posts() ) : ?>

    <?php $teachers->the_post(); ?>

    <div class="swiper-slide">

     <?php  pc_get_template_part('teacher/parts/teacher-card'); ?>

    </div>

   <?php endwhile; 
    wp_reset_postdata();?>
  </div>

  <button class="pc-teacher-slider-prev" type="button" aria-label="<?php _e('Previous teacher', 'psychology-courses'); ?>">←</button>

  <button
   class="pc-teacher-slider-next" type="button" aria-label="<?php _e('Next teacher', 'psychology-courses') ?>">→</button>

  <div class="swiper-pagination pc-teacher-slider-pagination">→</div>

 </div>

</section>

<?php

