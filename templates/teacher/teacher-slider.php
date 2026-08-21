<?php
/**
 * Teacher slider.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$course_id = $args['course_id'] ?? 0;

$teacher_ids = array();

/*
 * Course-specific slider.
 */
if ( $course_id ) {

 $teacher_ids = get_post_meta(
  $course_id,
  pc_get_course_teachers_meta_key(),
  true
 );

 if ( ! is_array( $teacher_ids ) ) {
  $teacher_ids = array();
 }

 $teacher_ids = array_map(
  'absint',
  $teacher_ids
 );

 $teacher_ids = array_filter(
  $teacher_ids
 );
}

/*
 * Query teachers.
 */
$query_args = array(
 'post_type'      => 'teacher',
 'post_status'    => 'publish',
 'posts_per_page' => -1,
 'orderby'        => 'title',
 'order'          => 'ASC',
);

/*
 * If course ID is provided,
 * show only assigned teachers.
 */
if ( ! empty( $teacher_ids ) ) {

 $query_args['post__in'] = $teacher_ids;

 /*
  * Keep the order from pc_course_teachers.
  */
 $query_args['orderby'] = 'post__in';

}

/*
 * If course has no teachers,
 * do not show all teachers accidentally.
 */
if ( $course_id && empty( $teacher_ids ) ) {
 return;
}

$teachers = new WP_Query( $query_args );

if ( ! $teachers->have_posts() ) {
 return;
}
?>

<section class="pc-teacher-slider">

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