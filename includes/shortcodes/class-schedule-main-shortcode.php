<?php

defined( 'ABSPATH' ) || exit;

class PC_Main_Schedule_Shortcode {

 public function __construct() {
  add_shortcode( 'main_schedule', array( $this, 'render' ) );
 }

 public function render( $atts ) {

  $atts = shortcode_atts(
   array(
    'month' => '',
    'year'  => '',
   ),
   $atts,
   'schedule'
  );

  $month = absint( $atts['month'] );
  $year  = absint( $atts['year'] );

  if ( ! $month || ! $year )  return '';
  //form_id
  $options = get_option( 'pc_plugin_settings', array() );

  $language = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'uk';

  $form_id = ( 'ru' === $language )
    ? absint( $options['cf7_form_id_ru'] ?? 0 )
    : absint( $options['cf7_form_id'] ?? 0 );

  $query = new WP_Query(
   array(
    'post_type'      => 'course-stream',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'no_found_rows'  => true,
    'meta_query'     => array(
     'relation' => 'AND',

     array(
      'key'     => '_pc_schedule_month',
      'value'   => $month,
      'compare' => '=',
      'type'    => 'NUMERIC',
     ),

     array(
      'key'     => '_pc_schedule_year',
      'value'   => $year,
      'compare' => '=',
      'type'    => 'NUMERIC',
     ),
    ),
   )
  );
 
  if ( ! $query->have_posts() )  return '';
  

  $stream_id = $query->posts[0]->ID;
  //$stream_title = $query->posts[0]->post_title;

  $stream_title = wp_date(
      'F Y',
      mktime( 12, 0, 0, $month, 1, $year )
  );


  $rows = get_post_meta( $stream_id,'pc_schedule_rows', true);

  if ( empty( $rows ) || ! is_array( $rows ) ) return '';


  
  ob_start();
  ?>
  
  <div class="pc-block">
    <h2><?php echo esc_html( mb_convert_case( $stream_title, MB_CASE_TITLE, 'UTF-8' ) ); ?></h2>
    <div class="wp-block-group schedule-main__group">
        <div class="wp-block-columns schedule-main__header">
            <div class="schedule-main__date">
                <?php _e ('Start date', 'psychology-courses' ); ?>
            </div>
            <div class="schedule-main__title">
                <?php _e ('Course title', 'psychology-courses' ); ?>
            </div>    
            <div class="wp-block-column">
                <?php _e ('Teacher', 'psychology-courses' ); ?>
            </div>
            <div class="wp-block-column">
                <?php _e ('Duration', 'psychology-courses' ); ?>
            </div>
            <div class="wp-block-column"></div>
    </div>
<?php
  foreach ( $rows as $row ) {
   $course_id = absint( $row['course_id'] );

    if ( $course_id && function_exists( 'pll_get_post' ) ) {
        $translated_id = pll_get_post( $course_id );

        if ( $translated_id )  $course_id = $translated_id;
    }

    $course_name = get_the_title( $course_id );
    $course_url  = get_permalink( $course_id );
    
    //teacher
    $teacher_id = absint( $row['teacher_id'] );

    if ( $teacher_id && function_exists( 'pll_get_post' ) ) {
        $translated_id = pll_get_post( $teacher_id );

        if ( $translated_id ) $teacher_id = $translated_id;  
    }

    $teacher_name = get_the_title( $teacher_id );
    $teacher_url  = get_permalink( $teacher_id );
   ?>
   <div class="schedule-main__card align-items-center <?php echo esc_attr( $row['icon_class'] ); ?>">  
    <?php if ( ! empty( $row['date'] ) ) : ?>
      <div class="schedule-main__date"> 
        <?php $date = strtotime($row['date']); 
            $day = '<span class="schedule-main-day">'. wp_date( 'd', $date). '</span>';
            $week_day = '<span class="schedule-main-weekday">'. wp_date( 'D', $date). '</span>';
        ?>
        <?php echo $day.' '. $week_day; ?>
        <span class="schedule-main-time"><?php _e( ' from', 'psychology-courses' );  ?> <?php echo ! empty( $row['time'] ) ? esc_html( $row['time'] ) : "10:00"; ?></span>   
      </div>
    <?php endif; ?>  
    <div class="d-flex-between schedule-main__content">
    <?php if ( ! empty( $course_name ) ) : ?>
      <div class="schedule-main__title">
       <strong><a href="<?php echo $course_url; ?>"><?php echo esc_html( $course_name ); ?></a> </strong>
      </div>
     <?php endif; ?>

      <div class="schedule-main__teacher">
       <a href="<?php echo $teacher_url; ?>"><?php echo esc_html( $teacher_name ); ?></a>
      </div>
     
     <?php if ( ! empty( $row['duration'] ) ) : 
        $duration = esc_html( $row['duration'] );
        $lessons  = ! empty( $row['lessons'] ) ?  esc_html( $row['lessons'] ) : "10"; ?>
      <div class="schedule-main__duration">
       <?php printf( _n('%d month','%d months', $duration, 'psychology-courses'), $duration); ?>
        | <?php echo $lessons; ?> <?php  _e (' lessons', 'psychology-courses' );   ?>
      </div>
     <?php endif; ?>
     <?php   
         $stream =  ! empty( $row['stream']) ? $row['stream'] : 1;
         $registration_shortcode = sprintf(
            '[cf7ip_button form_id="%d" text="%s" title="%s" animation="fade" course="%s" course_stream="%s" teacher="%s"]',
            $form_id,
            esc_attr__( 'Sign up', 'psychology-courses' ),
            esc_attr__( 'Registration for', 'psychology-courses' ) . " ". $course_name ,
            $course_name . ' '. $stream . "&nbsp;". __("stream", 'psychology-courses'),
            $stream,
            $teacher_name
        );
     ?>
      <div class="schedule-main__button">
       <?php echo do_shortcode( $registration_shortcode ); ?>
      </div>

    </div><!-- /.schedule-main__content -->
   </div>
   <?php  } ?>
</div>
</div><!--/.block-->

<?php
  return ob_get_clean();
 }
}