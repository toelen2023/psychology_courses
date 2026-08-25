<?php
/**
 * Course card.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$course_id = get_the_ID();

$course_url = get_permalink( $course_id );

$duration = get_post_meta($course_id, pc_get_duration_meta_key(), true  );
?>

<article class="pc-course-card d-flex-column">

 <div class="pc-course-card__content">

  <?php  $categories = get_the_terms( $course_id,'course_category');  ?>

  <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>

   <div class="pc-course-card__categories d-flex-between flex-wrap">

        <?php foreach ( $categories as $category ) : ?>

        <span class="pc-course-card__badge <?php echo esc_html( $category->slug ); ?>">
        <?php echo esc_html( $category->name ); ?>
        </span>

        <?php endforeach; ?>
        <span class="pc-course-card__badge">  
            <?php
                printf(
                    esc_html( _n('%d month', '%d months',
                    (int) $duration, 'psychology-courses' )
                    ), (int) $duration  );
            ?>
        </span>
   </div>  
   

  <?php endif; ?>

 <a href="<?php echo esc_url( $course_url ); ?>">
  <h4 class="pc-course-card-title"><?php the_title(); ?></h4>
 </a>

  <?php if ( has_excerpt() ) : ?>

   <div class="pc-course-card__excerpt">

    <?php the_excerpt(); ?>

   </div>

  <?php endif; ?>

  </div>
  <div class="pc-course-card__buttons d-flex-between flex-wrap">

    <?php echo do_shortcode('[cf7ip_button form_id="081af97" text="'. __('Sign up for a course','psychology-courses'). '" title="'. __('Sign up for a course '.get_the_title(),'psychology-courses'). '" animation="slide-left" course="'.get_the_title().'"] ');
    ?>

   <a class="button pc-course-btn-more" href="<?php echo esc_url( $course_url ); ?>" >
    <?php esc_html_e('More', 'psychology-courses');  ?>
  </a>
  </div>
</article>