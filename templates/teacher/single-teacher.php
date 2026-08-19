<?php
/**
 * Single Teacher template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
 the_post();

 $teacher_id = get_the_ID();
 $consult_price = get_post_meta( $teacher_id, pc_get_consultation_price_meta_key(), true );
 ?>

 <main class="site-main" id="main">
   <article <?php post_class(); ?>>
    <div class="inside-article pc-teacher">
     

        <header class="entry-header pc-teacher-header">    
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>
    
       <div class="entry-content d-flex-between" itemprop="text">
        <div class="pc-teacher-info column-1-4">
         <?php if ( has_post_thumbnail() ) : ?>

            <div class="pc-teacher-image">
                <?php
                the_post_thumbnail('medium',
                    array('alt' => get_the_title(),  )
                );
                ?>
            </div>

         <?php endif; ?>
         <p><strong><?php  _e( 'Consultation Price', 'psychology-courses' ) ?></strong> <?php echo  $consult_price ?> грн.</p>

         <div class="pc-teacher-courses">

            <h3>
                <?php esc_html_e( 'Courses', 'psychology-courses' ); ?>
            </h3>

            <?php
            $courses = new WP_Query(
                array(
                'post_type'      => 'course',
                'post_status'    => 'publish',
                'posts_per_page' => -1,

                'meta_query'     => array(
                    array(
                        'key'     => pc_get_course_teachers_meta_key(),
                        'value'   => 'i:' . absint( $teacher_id ) . ';',
                        'compare' => 'LIKE',
                    ), ),

                'orderby'        => 'title',
                'order'         => 'ASC',
                ) );
                // print_r($courses);
            ?>

        <?php if ( $courses->have_posts() ) : ?>

            <ul class="pc-teacher__course-list">

            <?php while ( $courses->have_posts() ) : ?>

            <?php $courses->the_post(); ?>

            <?php 
            $course_id = get_the_ID();
            $short_title = get_post_meta( $course_id, 'pc_course_short_title',  true); 
            
                ?>

            <li class="pc-teacher__course-item">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    if ( $short_title ) echo esc_html( $short_title );
                    else the_title();  
                    ?>
                </a>
            </li>

            <?php endwhile; ?>

            </ul>

            <?php wp_reset_postdata(); ?>

         <?php else : ?>

            <p><?php esc_html_e('Courses are not available yet.', 'psychology-courses' ); ?></p>

         <?php endif; ?>

         </div>
         <?php 
            echo do_shortcode('[cf7ip_button form_id="081af97" text="'. __("Sign Up for a consultation", 'psychology-courses' ) .'" title="'. __("Sign Up for a consultation", 'psychology-courses' ) .'" animation="fade" teacher="' .get_the_title(). '"]'); 
         ?>
        </div>
        <div class="pc-teacher-content column-3-4" itemprop="text">

            <?php the_content(); ?>
       
        </section>
     </div>
    </div>
   </article>
 </main>

 <?php

endwhile;

get_footer();