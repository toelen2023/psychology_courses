<?php
/**
 * Archive Course template.
 *
 * @package Psychology_Courses
 */
global $wp_query;

$course_ids = wp_list_pluck( $wp_query->posts, 'ID' );

get_header();

?>
<main class="site-main" id="main">
  <article <?php post_class(); ?>>
    <div class="inside-article pc-teachers-archive">
        <header class="entry-header pc-teacher-header">  
            <h1 class="entry-title"><?php _e( 'Courses', 'psychology-courses' ); ?></h1>
        </header>
        <div class="entry-content">
        <?php 
        $options = get_option( 'pc_plugin_settings', array() );

        if ( ! empty( $options['course_shortcode'] ) ) {
            echo do_shortcode( $options['course_shortcode'] );
        } else { ?>

          <?php pc_get_template_part( 'course/parts/course-card-filter' ); ?>
          <section class="pc-courses-grid">
            <?php
            $has_more_courses = $wp_query->found_posts > 6;

            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();

                    pc_get_template_part( 'course/parts/course-card' );

                endwhile;
                
                the_posts_pagination();
                PC_Course_Schema::output_course_list( $course_ids ); 
            endif;
            ?>
          </section>
          <?php if ( $has_more_courses ) : ?>
            <p>
                <button type="button" class="pc-course-cards__toggle center-button"
                    data-show-text="<?php esc_attr_e( 'Show more', 'psychology-courses' ); ?>"
                    data-hide-text="<?php esc_attr_e( 'Collapse', 'psychology-courses' ); ?>">
                    <?php esc_html_e( 'Show more', 'psychology-courses' ); ?>
                </button>
            </p>
            <?php  endif; ?>
        <?php  }  ?>
     </div>
    </div>
  </article>
</main>
<?php  
PC_Course_Schema::output_course_list( $course_ids );
get_footer();
