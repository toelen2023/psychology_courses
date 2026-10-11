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
   <h1 class="entry-title mb-30"> <?php post_type_archive_title(); ?></h1>
  </header>
   <?php if ( have_posts() ) : ?>
    <div class="pc-reviews-list d-flex-between flex-wrap">
    <?php while ( have_posts() ) : ?>

     <?php the_post(); ?>

     <?php pc_get_template_part('review/parts/review-card'); ?>

    <?php endwhile; ?>
   </div>
   <?php else : ?>

   <div class="review-preview mb-60">
     <p class="text-bold"><?php  esc_html_e('Your real reviews will appear here soon.','psychology-courses');  ?></p>
     <p><?php  esc_html_e('Our project has just barely started its work.','psychology-courses');  ?></p>
     <p><?php  esc_html_e('And although our instructors have extensive teaching experience in other projects and a great many glowing reviews, that is not our story.','psychology-courses');  ?></p>
     <p class="text-bold"><?php  esc_html_e('We will write ours together with you!','psychology-courses');  ?>❤️</p>
    </div>
   <?php endif; ?>
   
  
  <?php echo do_shortcode('[review_form]'); ?>
 </div>
</main>

<?php
get_footer();