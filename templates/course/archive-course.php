<?php
/**
 * Archive Course template.
 *
 * @package Psychology_Courses
 */
get_header();
?>
<main class="site-main" id="main">
  <article <?php post_class(); ?>>
    <div class="inside-article pc-teachers-archive">
        <header class="entry-header pc-teacher-header">  
            <h1 class="entry-title"><?php _e( 'Courses', 'psychology-courses' ); ?></h1>
        </header>
        <div class="entry-content">
            <section class="pc-courses-grid">
            <?php if ( have_posts() ) :

            while ( have_posts() ) :

            the_post(); 
            ?>       
                <?php pc_get_template_part( 'course/parts/course-card' ); ?>
            <?php endwhile;

            the_posts_pagination();

            endif;
            ?>
        </section>
     </div>
    </div>
  </article>
</main>
<?php  
get_footer();
