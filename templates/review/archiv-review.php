<?php
/**
 * Review archive template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="site-main" id="main">
 <div class="inside-article pc-reviews">
  <header class="entry-header">
   <h1 class="entry-title">
    <?php post_type_archive_title(); ?>
   </h1>
  </header>

  <div class="pc-reviews-list">
   <?php if ( have_posts() ) : ?>

    <?php while ( have_posts() ) : ?>

     <?php the_post(); ?>

     <?php pc_get_template_part('review/parts/review-card'); ?>

    <?php endwhile; ?>

   <?php else : ?>

    <p>
     <?php  esc_html_e('Your real reviews will appear here soon.','psychology-courses');//Незабаром, тут будуть ваші реальні, відгуки  ?>
    </p>

   <?php endif; ?>

  </div>
 </div>
</main>

<?php
get_footer();