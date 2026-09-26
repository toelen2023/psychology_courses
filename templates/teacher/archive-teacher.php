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
        <div class="entry-content">
          <?php if ( have_posts() ) : ?>

          <div class="pc-teachers-list">

          <?php while ( have_posts() ) : ?>

              <?php the_post(); ?>

              <?php pc_get_template_part('teacher/content-teacher' );  ?>

          <?php endwhile; ?>

          </div>

          <?php endif; ?>
      </div>
    </div>
    
    <div class="wp-block-button center-button">
      <a class="wp-block-button__link wp-element-button" href="https://anika-themes.in.ua/rozklad/">
        <b><?php _e( 'See courses schedule', 'psychology-courses' ); ?></b></a>
    </div>
  
    <div class="wp-block-columns olvia-form-bottom is-layout-flex wp-block-columns-is-layout-flex">
      <div class="wp-block-column olvia-form-header is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:66.66%">
        <h2><?php _e( 'Have you any question <strong>about the training?</strong>', 'psychology-courses' ); ?></h2>
        <p><em><?php _e( 'Fill out the application, and we will contact you to provide more details about the training format and courses, as well as help you reserve a spot in the group.', 'psychology-courses' ); ?></em></p>
      </div>

      <div class="wp-block-column olvia-form-order has-accent-background-color has-background is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:33.33%">
          <?php echo do_shortcode('[contact-form-7 id="'.pc_get_cf7_form_id().'" title="Замовлення курсу etc"]'); ?>
      </div>
    </div>
   </div>
  </article>
</main>

<?php

get_footer();