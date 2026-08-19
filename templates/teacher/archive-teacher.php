<?php
/**
 * Teacher archive template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

?>

<main class="site-main" id="main">
  <article <?php post_class(); ?>>
    <div class="inside-article pc-teachers-archive">
        <header class="entry-header pc-teacher-header">  
            <h1 class="entry-title"><?php _e( 'Our Teachers', 'psychology-courses' ); ?></h1>
        </header>

        <?php if ( have_posts() ) : ?>

        <div class="pc-teachers-list">

        <?php while ( have_posts() ) : ?>

            <?php the_post(); ?>

            <?php pc_get_template_part('teacher/content-teacher' );  ?>

        <?php endwhile; ?>

        </div>

        <?php endif; ?>
    </div>
  </article>
</main>

<?php

get_footer();