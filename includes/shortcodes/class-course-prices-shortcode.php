<?php
/**
 * Course prices shortcode.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;


class PC_Course_Prices_Shortcode {

   /**
   * Register shortcode.
   * @return void
   */
   public function register(): void {

      add_shortcode('course_prices',  array( $this, 'render' ) );
   }

   /**
   * Render course prices table.
   * @param array|string $atts Shortcode attributes.
   * @return string
   */
   public function render( $atts ): string {

      $atts = shortcode_atts(
            array(
               'ids' => '',
            ),
            $atts,
            'course_prices'
      );

      if ( empty( $atts['ids'] ) )  return '';
      

      /*
         * Convert IDs to array.
         * Preserve the order entered in shortcode.
         */
      $course_ids = array_map('intval', array_map('trim',  explode( ',', $atts['ids'] )));
      $course_ids = array_values( array_unique( array_filter( $course_ids )) );

      if ( empty( $course_ids ) ) return '';
      

      $courses = new WP_Query(
            array(
               'post_type'      => 'course',
               'post_status'    => 'publish',
               'post__in'       => $course_ids,
               'orderby'        => 'post__in',
               'posts_per_page' => -1,
               'no_found_rows'  => true,
            )
      );

      if ( ! $courses->have_posts() ) return '';
      

      $cf7_form_id = pc_get_cf7_form_id();

      ob_start();
      ?>

      <div class="wp-block-group schedule-list__group pc-course-prices">
       <div class="wp-block-columns schedule-list__header price-header">
        <div class="wp-block-column" style="flex-basis:75px"></div>
            <div class="wp-block-column schedule-list__title price-title">
                  <?php _e ('Course title', 'psychology-courses' ); ?>
            </div>

            <div class="wp-block-column">
               <?php _e ('Duration', 'psychology-courses' ); ?>
            </div>
            <div class="wp-block-column">
               <?php esc_html_e( 'Price pro 1 month', 'psychology-courses' ); ?>
            </div>

            <div class="wp-block-column"></div>

         </div>

            <?php
            while ( $courses->have_posts() ) :
               $courses->the_post();

               $course_id = get_the_ID();
               $course_title = get_the_title();
               $categories = get_the_terms( $course_id,'course_category'); 

             if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
               $categoriesNum = count( $categories );
               if( $categoriesNum>1) $extraClass="color-universal";
               else $extraClass = str_contains($categories[0]->slug, "begin") ? "color-beginner" : "color-psychologist";
             endif; 
              
             $icon_id = get_post_meta( $course_id, 'pc_course_icon', true);
             if ( $icon_id ) $icon_src= wp_get_attachment_image( $icon_id,'thumbnail', false );  
         
               //  Duration.            
               $duration = get_post_meta( $course_id, pc_get_duration_meta_key(), true );
               $lessons =   get_post_meta($course_id,'pc_lessons',true) ;

               //Monthly UAH price.            
               $prices = pc_get_course_prices( $course_id );
               $monthly_price = $prices['uah']['month'] ?? '';

               //Teachers assigned to the course.
               $teacher_ids = get_post_meta( $course_id, pc_get_course_teachers_meta_key(), true );

               if ( ! is_array( $teacher_ids ) )  $teacher_ids = array();
               
               $teacher_names = array();
               foreach ( $teacher_ids as $teacher_id ) {
                  $teacher_name = get_the_title( (int) $teacher_id );
                  if ( $teacher_name )  $teacher_names[] = $teacher_name;                 
               }
               $teacher_names = implode( ', ', $teacher_names );

               //Build CF7 button shortcode.
               $button = '';

               if ( $cf7_form_id ) {
                  $button_shortcode = sprintf(
                        '[cf7ip_button form_id="%s" text="Записатися" title="Заявка на курс %s" form_button="Відправити заявку" animation="fade" course="%s" teacher="%s"]',
                        sanitize_text_field( $cf7_form_id ),
                        sanitize_text_field( $course_title ),
                        sanitize_text_field( $course_title ),
                        sanitize_text_field( $teacher_names )
                  );

                  $button = do_shortcode( $button_shortcode );
               }
               ?>

               <div class="wp-block-columns is-layout-flex schedule-list__card course-price__card <?php echo $extraClass; ?>">
                  
                  <div class="wp-block-column schedule-list__logo">
                     <?php echo  $icon_src ; ?>
                  </div>
                  <div class="wp-block-column schedule-list__title">
                        <a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>">
                           <?php echo esc_html( $course_title ); ?>
                           </a>
                     </div>

                  <div class="wp-block-column schedule-list__duration">
                        <?php
                       
                        if ( $duration )  {
                           printf( esc_html( _n('%d month', '%d months',
                           (int) $duration, 'psychology-courses' ) ), (int) $duration  );
                           echo " | ";
                           printf( esc_html( _n('%d lesson', '%d lessons',
                           (int)  $lessons, 'psychology-courses' ) ), (int)  $lessons  );
                        } else  echo '';
                        ?>
                  </div>

                  <div class="wp-block-column schedule-list__price">
                        <?php
                        if ( '' !== $monthly_price )  echo esc_html( $monthly_price ) . ' грн.';
                        else   echo '';

                        ?>
                  </div>

                  <div class="wp-block-column schedule-list__button">
                        <?php
                        echo $button; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        ?>
                  </div>

               </div>

            <?php endwhile; ?>

      </div>

      <?php

      wp_reset_postdata();

      return ob_get_clean();
   }

   /**
   * Format course duration in Ukrainian.
   * @param int $months Number of months.
   * @return string
   */
   private function format_duration( int $months ): string {

      if ( 1 === $months ) return '1 місяць';
      

      if (
            $months % 10 >= 2 &&
            $months % 10 <= 4 &&
            ! in_array( $months % 100, array( 12, 13, 14 ), true )
      ) return $months . ' місяці';
      
      return $months . ' місяців';
   }
}
