<?php
/**
 * Archive Course template.
 *
 * @package Psychology_Courses
 */
get_header();
$course_categories = get_terms(
 array(
  'taxonomy'   => 'course_category',
  'hide_empty' => true,
 )
);
?>
<main class="site-main" id="main">
  <article <?php post_class(); ?>>
    <div class="inside-article pc-teachers-archive">
        <header class="entry-header pc-teacher-header">  
            <h1 class="entry-title"><?php _e( 'Courses', 'psychology-courses' ); ?></h1>
        </header>
        <div class="entry-content">
            <div class="pc-course-filters" style="margin-bottom: 15px;">
                <button type="button" class="pc-course-filter is-active" data-filter="all">
                <?php _e( 'All courses', 'psychology-courses' ); ?></button>

                <?php if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) : ?>

                <?php foreach ( $course_categories as $category ) : ?>

                <button type="button" class="pc-course-filter"
                 data-filter="<?php echo esc_attr( $category->slug ); ?>">
                    <?php echo esc_html( $category->name ); ?>
                </button>

                <?php endforeach; ?>

                <?php endif; ?>

            </div>
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
