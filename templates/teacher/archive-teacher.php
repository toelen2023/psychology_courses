<?php
/**
 * Teacher archive template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

?>

<main class="pc-teachers-archive">
    <h1>Teachers</h1>

 <?php if ( have_posts() ) : ?>

  <div class="pc-teachers-list">

   <?php while ( have_posts() ) : ?>

    <?php the_post(); ?>

    <?php pc_get_template_part('teacher/content-teacher' );  ?>

   <?php endwhile; ?>

  </div>

 <?php endif; ?>

</main>

<?php

get_footer();