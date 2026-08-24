<?php
/**
 * Single Course template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
 the_post();

 //$prices = pc_get_course_prices( get_the_ID() );

 $duration = get_post_meta(get_the_ID(), pc_get_duration_meta_key(), true  );
?>

<main class="pc-course">
 <article>
    <div class="inside-article">
        <header class="entry-header pc-course-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>
        <div class="entry-content">

        <p class="pc-course-meta">
            <strong><?php esc_html_e( 'Duration:', 'psychology-courses' ); ?></strong>
            <?php
                printf(
                    esc_html( _n('%d month', '%d months',
                    (int) $duration, 'psychology-courses' )
                    ), (int) $duration  );
            ?>
        </p>

        <section class="pc-course__content">

        <?php the_content(); ?>

        </section>

        <section class="pc-course__prices">

            <h4 class="entry-header" itemprop="headline">
            <?php esc_html_e( 'Course price', 'psychology-courses'); ?>
            </h4>

        <?php 
            //pc_get_template_part( 'course/parts/course-price-table' ); 
            pc_get_template_part( 'course/parts/course-price-month' ); 
        ?>

        </section>
      </div>  
    </div>
  </article>   
</main>

<?php

endwhile;

get_footer();