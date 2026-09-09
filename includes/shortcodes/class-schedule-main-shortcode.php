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
  $stream_title = $query->posts[0]->post_title;

  $rows = get_post_meta( $stream_id,'pc_schedule_rows', true);

  if ( empty( $rows ) || ! is_array( $rows ) ) return '';


  
  ob_start();
  ?>
  
  <div class="pc-block">
    <h2><?php echo $stream_title ?></h2>
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
   $course_url = get_permalink( $row['course_id'] );
   $teacher_url = get_permalink( $row['teacher_id'] );
   ?>
   <div class="schedule-main__card align-items-center  <?php echo $row["icon_class"]; ?>">  
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
    <?php if ( ! empty( $row['course_name'] ) ) : ?>
      <div class="schedule-main__title">
       <strong><a href="<?php echo $course_url; ?>"><?php echo esc_html( $row['course_name'] ); ?></a> </strong>
      </div>
     <?php endif; ?>
    <?php if ( ! empty( $row['teacher_name'] ) ) : ?>
      <div class="schedule-main__teacher">
       <a href="<?php echo $teacher_url; ?>"><?php echo esc_html( $row['teacher_name'] ); ?></a>
      </div>
     <?php endif; ?>
     
     <?php if ( ! empty( $row['duration'] ) ) : 
        $duration = esc_html( $row['duration'] );
        $lessons  = ! empty( $row['lessons'] ) ?  esc_html( $row['lessons'] ) : "10"; ?>
      <div class="schedule-main__duration">
       <?php printf( _n('%d month','%d months', $duration, 'psychology-courses'), $duration); ?> | <?php echo $lessons; ?> <?php  _e (' lessons', 'psychology-courses' );   ?>
      </div>
     <?php endif; ?>

     

     <?php if ( ! empty( $row['registration'] ) ) : ?>
      <div class="schedule-main__button">
       <?php echo do_shortcode( $row['registration'] ); ?>
      </div>
     <?php endif; ?>

    </div><!-- /.schedule-main__content -->
   </div>
   <?php  } ?>
 </div>
</div>
</div><!--/.block-->

<?php
  return ob_get_clean();
 }
}