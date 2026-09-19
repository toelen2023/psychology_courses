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
$extraClass="color-universal";
?>

<article class="pc-course-card d-flex-column">

<?php  $categories = get_the_terms( $course_id,'course_category');  ?>

    <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
      $categoriesNum = count( $categories );
      if( $categoriesNum>1) $extraClass="color-universal";
      else $extraClass = str_contains($categories[0]->slug, "begin") ? "color-beginner" : "color-psychologist";
    ?>
    <div class="pc-course-card__categories d-flex-between flex-wrap">

          <?php foreach ( $categories as $category ) : ?>

          <span class="pc-course-card__badge <?php echo esc_html( $category->slug ); ?>">
          <?php echo esc_html( $category->name ); ?>
          </span>

          <?php endforeach; ?>
          <span class="pc-course-card__badge">  
              <?php printf( esc_html( _n('%d month', '%d months',
                      (int) $duration, 'psychology-courses' )), (int) $duration  ); ?>
          </span>
    </div>  
    <?php endif; ?>
  <div class="course-card__main d-flex-between align-items-center"> 
    <div class="d-flex-column">
      <div class="pc-course-card__content">
        <a href="<?php echo esc_url( $course_url ); ?>">
          <h4 class="pc-course-card-title"><?php the_title(); ?>
          <span class="pc-course-card__badge badge-months-mobile">  
              <?php printf( esc_html( _n('%d month', '%d months',
                      (int) $duration, 'psychology-courses' )), (int) $duration  ); ?>
          </span>
        </h4>
        </a>
      <?php if ( has_excerpt() ) : ?>
        <div class="pc-course-card__excerpt">
          <?php the_excerpt(); ?>
        </div>
      <?php endif; ?>
      </div> <!--/.content-->
      <div class="pc-course-card__buttons d-flex-between flex-wrap">
          <?php echo do_shortcode('[cf7ip_button form_id="'.pc_get_cf7_form_id().'" text="'. __('Sign up for a course','psychology-courses'). '" title="'. __('Sign up for','psychology-courses'). ' '.get_the_title(). '" animation="slide-left" course="'.get_the_title().'"] ');
          ?>
        <a class="button pc-course-btn-more" href="<?php echo esc_url( $course_url ); ?>" >
          <?php esc_html_e('More', 'psychology-courses');  ?>
        </a>
      </div><!--/.buttons -->
    </div><!--/.flex-column-->
    <!-- <?php if ( has_post_thumbnail( $course_id ) ) : ?>
    <div class="pc-course-card__image">
        <?php   echo get_the_post_thumbnail( $course_id, 'medium',  
         array('class' => 'pc-course-card__featured-image',));   ?>
    </div>
    <?php endif; ?> -->
    
    <?php $icon_id = get_post_meta( $course_id,'pc_course_icon', true); ?>
    <?php if ( $icon_id ) : ?>
      <div class="pc-course-card__deco <?php echo $extraClass; ?>"></div>
      <div class="pc-course-card__icon">
          <?php  echo wp_get_attachment_image( (int) $icon_id, 'thumbnail',
              false,  array( 'class' => 'pc-course-card__icon-image', ) ); ?>
      </div>

    <?php endif; ?>
    
  </div><!--/.main-->
</article>