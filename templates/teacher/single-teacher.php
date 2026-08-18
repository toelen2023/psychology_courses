<?php
/**
 * Single Teacher template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
 the_post();

 $teacher_id = get_the_ID();
 ?>

 <main class="site-main" id="main">
   <article <?php post_class(); ?>>
    <div class="inside-article pc-teacher">

    <header class="entry-header pc-teacher-header">

    <?php if ( has_post_thumbnail() ) : ?>

        <div class="pc-teacher-image">

        <?php
        the_post_thumbnail(
        'medium',
        array('alt' => get_the_title(),  )
        );
        ?>

        </div>

    <?php endif; ?>

    <div class="pc-teacher-info">

        <h1 class="entry-title pc-teacher-title">
        <?php the_title(); ?>
        </h1>

    </div>

    </header>

    <section class="pc-teacher-content">

    <?php the_content(); ?>

    </section>

    <section class="pc-teacher-courses">

    <h2>
        <?php esc_html_e( 'Courses', 'psychology-courses' ); ?>
    </h2>

    <?php
    $courses = new WP_Query(
            array(
            'post_type'      => 'course',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => array(
            array(
                'key'     => pc_get_course_teachers_meta_key(),
                'value'   => '"' . $teacher_id . '"',
                'compare' => 'LIKE',
            ), ),
            'orderby'        => 'title',
            'order'          => 'ASC',
            ) );

            print_r($courses);
    ?>

    <?php if ( $courses->have_posts() ) : ?>

        <ul class="pc-teacher__course-list">

        <?php while ( $courses->have_posts() ) : ?>

        <?php $courses->the_post(); ?>

        <li class="pc-teacher__course-item">

        <a href="<?php the_permalink(); ?>">

            <?php the_title(); ?>

        </a>

        </li>

        <?php endwhile; ?>

        </ul>

        <?php wp_reset_postdata(); ?>

    <?php else : ?>

        <p>
        <?php
        esc_html_e('Courses are not available yet.', 'psychology-courses' );
        ?>
        </p>

    <?php endif; ?>

    </section>
   </div>
   </article>
 </main>

 <?php

endwhile;

get_footer();