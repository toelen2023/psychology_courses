<?php
/**
 * Single review template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main class="site-main" id="main">
  <article <?php post_class(); ?>>
     <div class="inside-article pc-review">
     <?php  pc_get_template_part('review/parts/review-card'); ?>
    </div>
 </article>
</main>

<?php
get_footer();