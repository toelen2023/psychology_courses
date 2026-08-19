<?php
/**
 * List of Teachers courses.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_id = get_the_ID();

<div class="pc-teacher-courses">

    <h3>
        <?php esc_html_e( 'Courses', 'psychology-courses' ); ?>
    </h3>

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
        // print_r($courses);
    ?>

    <?php if ( $courses->have_posts() ) : ?>

     <ul class="pc-teacher__course-list">

       <?php while ( $courses->have_posts() ) : ?>

         <?php $courses->the_post(); ?>

            <?php 
             $course_id = get_the_ID();
             $short_title = get_post_meta( $course_id, 'pc_course_short_title',  true); 
            ?>

            <li class="pc-teacher__course-item">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if ( $short_title ) echo esc_html( $short_title );
                    else the_title();  
                    ?>
                </a>
            </li>

        <?php endwhile; ?>

     </ul>

     <?php wp_reset_postdata(); ?>

    <?php else : ?>

        <p><?php esc_html_e('Courses are not available yet.', 'psychology-courses' ); ?></p>

    <?php endif; ?>

</div>