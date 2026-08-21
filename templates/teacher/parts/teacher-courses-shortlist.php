<?php
/**
 * List of Teachers courses.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_id = get_the_ID();
?>

<div class="pc-teacher-courses-shortlist">

    <?php
    $courses = new WP_Query(
        array(
        'post_type'      => 'course',
        'post_status'    => 'publish',
        'posts_per_page' => -1,

        'meta_query'     => array(
            array(
                'key'     => pc_get_course_teachers_meta_key(),
                'value'   => 'i:' . absint( $teacher_id ) . ';',
                'compare' => 'LIKE',
            ), ),

        'orderby'        => 'title',
        'order'         => 'ASC',
        ) );
    ?>

    <?php if ( $courses->have_posts() ) : ?>

     <ul class="unstyled text-bold">

       <?php while ( $courses->have_posts() ) : ?>

         <?php $courses->the_post(); ?>

            <?php 
             $course_id = get_the_ID();
             $short_title = get_post_meta( $course_id, 'pc_course_short_title',  true); 
            ?>

            <li class="pc-teacher-shortlistcourse-item d-inline">
                <a href="<?php the_permalink(); ?>"><?php
                    if ( $short_title ) echo esc_html( $short_title );
                    else the_title();  ?></a>
            </li>

        <?php endwhile; ?>

     </ul>

     <?php wp_reset_postdata(); ?>

    <?php endif; ?>

</div>