<?php
/**
 * Teacher slider.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_ids = $template_args['teacher_ids'] ?? array();

$teachers = new WP_Query(
 array(
  'post_type'      => 'teacher',
  'post_status'    => 'publish',
  'post__in'       => $teacher_ids,
  'orderby'        => 'post__in',
  'posts_per_page' => -1,
 )
);


if ( ! $teachers->have_posts() ) return;

$teacher_count = $teachers->post_count;
if ( 1 === $teacher_count ) : 
    $teachers->the_post();
?>
    <section class="pc-teacher-list pc-teacher-list--single">

        <div class="pc-teacher-list__item">
            <?php pc_get_template_part( 'teacher/parts/teacher-horizontal-card' ); ?>
        </div>

    </section>
<?php elseif ( $teacher_count <= 3 ) : ?>

    <section class="pc-teacher-list pc-teacher-list--small"
        data-teachers-count="<?php echo esc_attr( $teacher_count ); ?>">

        <div class="pc-teacher-list__desktop">

            <?php while ( $teachers->have_posts() ) : ?>

                <?php $teachers->the_post(); ?>

                <div class="pc-teacher-list__item">

                  <?php pc_get_template_part('teacher/parts/teacher-card'); ?>

                </div>

            <?php endwhile; ?>
        </div>
        <div class="pc-teacher-list__mobile swiper">

            <div class="swiper-wrapper">

                <?php
                /*
                 * Reset the query so that we can use
                 * the same teachers for the mobile slider.
                 */
                $teachers->rewind_posts();
                ?>

                <?php while ( $teachers->have_posts() ) : ?>

                    <?php $teachers->the_post(); ?>

                    <div class="swiper-slide">

                      <?php pc_get_template_part('teacher/parts/teacher-card'); ?>

                        <a class="pc-teacher-list__more" href="<?php the_permalink(); ?>">
                            <?php esc_html_e( 'More', 'psychology-courses' ); ?>
                        </a>

                    </div>

                <?php endwhile; ?>

            </div>
            <button class="pc-teacher-list__prev" type="button"
                aria-label="<?php esc_attr_e( 'Previous teacher', 'psychology-courses' ); ?>">
                ←
            </button>

            <button class="pc-teacher-list__next" type="button"
                aria-label="<?php esc_attr_e( 'Next teacher', 'psychology-courses' ); ?>">
                →
            </button>

            <div class="pc-teacher-list__pagination"></div>

        </div>
</section>

<?php else : 
  //Existing slider for 4+ teachers. ?>


<section class="pc-teacher-slider">

 <div class="swiper pc-teacher-slider-swiper">

  <div class="swiper-wrapper">

   <?php while ( $teachers->have_posts() ) : ?>

    <?php $teachers->the_post(); ?>

    <div class="swiper-slide">

     <?php  pc_get_template_part('teacher/parts/teacher-card'); ?>

    </div>

   <?php endwhile; 
    wp_reset_postdata();?>
  </div>

  <button class="pc-teacher-slider-prev" type="button" aria-label="<?php _e('Previous teacher', 'psychology-courses'); ?>">←</button>

  <button
   class="pc-teacher-slider-next" type="button" aria-label="<?php _e('Next teacher', 'psychology-courses') ?>">→</button>

  <div class="swiper-pagination pc-teacher-slider-pagination">→</div>

 </div>

</section>

<?php endif; ?>

<?php wp_reset_postdata(); ?>