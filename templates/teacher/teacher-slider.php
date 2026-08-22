<?php
/**
 * Teacher slider.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_ids = $args['teacher_ids'] ?? array();
print_r($teacher_ids);

$teachers = new WP_Query(
 array(
  'post_type'      => 'teacher',
  'post_status'    => 'publish',
  'post__in'       => $teacher_ids,
  'orderby'        => 'post__in',
  'posts_per_page' => -1,
 )
);

print_r($teachers);
if ( ! $teachers->have_posts() ) return;

?>

<section class="pc-teacher-slider">
<h2>Slider</h2>
 <div class="swiper pc-teacher-slider__swiper">

  <div class="swiper-wrapper">

   <?php while ( $teachers->have_posts() ) : ?>

    <?php $teachers->the_post(); ?>

    <div class="swiper-slide">

     <?php
     pc_get_template_part(
      'teacher/parts/teacher-card'
     );
     ?>

    </div>

   <?php endwhile; ?>

  </div>

  <button
   class="swiper-button-prev pc-teacher-slider__prev"
   type="button"
  ></button>

  <button
   class="swiper-button-next pc-teacher-slider__next"
   type="button"
  ></button>

  <div class="swiper-pagination pc-teacher-slider__pagination"></div>

 </div>

</section>

<?php

wp_reset_postdata();