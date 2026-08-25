<?php
/**
 * Course cards shortcode.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'PC_Course_Cards_Shortcode' ) ) {

 /**
  * Course cards shortcode.
  */
 class PC_Course_Cards_Shortcode {
  
  public function __construct() {

   add_shortcode( 'course_cards', array( $this, 'render' )  );

  }

  /**
   * Render course cards.
   * @param array|string $atts Shortcode attributes.
   * @return string
   */
  public function render( $atts ): string {

   $atts = shortcode_atts(
    array(
     'ids'         => '',
     'show_filter' => 'yes',
    ),
    $atts,
    'course_cards'
   );

   // IDs are required.
 
   if ( empty( $atts['ids'] ) ) {
    return '';
   }

   // Convert IDs string to array.
 
   $course_ids = array_map(
    'intval', array_map( 'trim',  explode( ',', $atts['ids'] )  )
   );

   //Remove invalid IDs and duplicates,  while preserving the entered order.
  
   $course_ids = array_values(  array_unique(array_filter( $course_ids ) ) );

   if ( empty( $course_ids ) )  return '';
   
   // Get courses in the exact order specified in the shortcode.
    
   $courses = new WP_Query(
    array(
     'post_type'      => 'course',
     'post_status'    => 'publish',
     'post__in'       => $course_ids,
     'orderby'        => 'post__in',
     'posts_per_page' => -1,
    )
   );

   if ( ! $courses->have_posts() )  return '';
   $has_more_courses = $courses->post_count > 6; 
   ob_start();
   ?>

   <div class="pc-course-cards">

    <?php if ( 'yes' === $atts['show_filter'] ) : ?>

     <?php $this->render_filters( $course_ids ); ?>

    <?php endif; ?>

    <div class="pc-courses-grid">
     <?php
     while ( $courses->have_posts() ) :
      $courses->the_post();

      pc_get_template_part( 'course/parts/course-card',
       array( 'course_id' => get_the_ID(), )  );

     endwhile;
     ?>
    </div>
    <?php if ( $has_more_courses ) : ?>
        <button type="button" class="pc-course-cards__toggle"
        data-show-text="<?php esc_attr_e( 'Дивитись ще', 'psychology-courses' ); ?>"
        data-hide-text="<?php esc_attr_e( 'Згорнути', 'psychology-courses' ); ?>"
        >
        <?php esc_html_e( 'Дивитись ще', 'psychology-courses' ); ?>
        </button>

        <?php endif; ?>
    
   </div>

   <?php
   wp_reset_postdata();

   return ob_get_clean();
  }

  /**
   * Render course filters.
   * @param array $course_ids Course IDs.
   * @return void
   */
  private function render_filters( array $course_ids ): void {
     pc_get_template_part( 'course/parts/course-card-filter' );  
  }
 }
}