<?php
/**
 * Archive Course template.
 *
 * @package Psychology_Courses
 */
get_header();

if ( have_posts() ) :

 while ( have_posts() ) :

  the_post();

  pc_get_template_part( 'course/parts/course-card' );

 endwhile;

 the_posts_pagination();

endif;

get_footer();
