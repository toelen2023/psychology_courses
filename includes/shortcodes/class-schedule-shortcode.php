<?php

defined( 'ABSPATH' ) || exit;

class PC_Schedule_Shortcode {

 public function __construct() {
  add_shortcode( 'schedule', array( $this, 'render' ) );
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

  $rows = get_post_meta( $stream_id,'pc_schedule_rows', true);

  if ( empty( $rows ) || ! is_array( $rows ) ) return '';
  
  ob_start();?>
  <div class="wp-block-group schedule-list__group">
    <div class="wp-block-columns schedule-list__header">
        <div class="wp-block-column" style="flex-basis:75px"></div>
        <div class="wp-block-column schedule-list__title">
            <?php _e ('Course title', 'psychology-courses' ); ?>
        </div>
        <div class="wp-block-column">
            <?php _e ('Start date', 'psychology-courses' ); ?>
        </div>
        <div class="wp-block-column">
            <?php _e ('Duration', 'psychology-courses' ); ?>
        </div>
        <div class="wp-block-column">
            <?php _e ('Teacher', 'psychology-courses' ); ?>
        </div>
        <div class="wp-block-column"></div>
    </div><!--/.schedule-list__header-->
<?php
  foreach ( $rows as $row ) {
   $course_url = get_permalink( $row['course_id'] );
   $teacher_url = get_permalink( $row['teacher_id'] );
   ?>
   <div class="wp-block-columns is-layout-flex schedule-list__card <?php echo $row["icon_class"]; ?>">
   
   <div class="wp-block-column schedule-list__logo">
    <?php
    if ( ! empty( $row['icon_id'] ) ) 
        echo wp_get_attachment_image( absint( $row['icon_id'] ),'thumbnail');   
    ?>
    </div>
    

     <?php if ( ! empty( $row['course_name'] ) ) : ?>
      <div class="wp-block-column schedule-list__title">
       <strong><a href="<?php echo $course_url; ?>"><?php echo esc_html( $row['course_name'] ); ?>
        <?php if ( ! empty( $row['stream'] ) ) : ?>
            -&nbsp;<?php echo esc_html( $row['stream'] ) . "&nbsp;". __("stream", 'psychology-courses'); ?></a>
        <?php endif; ?>
        </strong>
      </div>
     <?php endif; ?>

     <?php if ( ! empty( $row['date'] ) ) : ?>
      <div class="wp-block-column schedule-list__date">  
        <?php echo  wp_date( 'd F', strtotime($row['date']) ). __( ' from', 'psychology-courses' );  ?> <?php echo ! empty( $row['time'] ) ? esc_html( $row['time'] ) : "10:00"; ?>
      </div>
     <?php endif; ?>


     <?php if ( ! empty( $row['duration'] ) ) : 
        $duration = esc_html( $row['duration'] );
        $lessons  = ! empty( $row['lessons'] ) ?  esc_html( $row['lessons'] ) : "10"; ?>
      <div class="wp-block-column schedule-list__duration">
       <b><?php printf( _n('%d month','%d months', $duration, 'psychology-courses'), $duration); ?></b> | <?php echo $lessons; ?> <?php  _e (' lessons', 'psychology-courses' );   ?>
      </div>
     <?php endif; ?>

     <?php if ( ! empty( $row['teacher_name'] ) ) : ?>
      <div class="wp-block-column schedule-list__teacher">
       <a href="<?php echo $teacher_url; ?>"><?php echo esc_html( $row['teacher_name'] ); ?></a>
      </div>
     <?php endif; ?>

     <?php if ( ! empty( $row['registration'] ) ) : ?>
      <div class="wp-block-column schedule-list__button">
       <?php echo do_shortcode( $row['registration'] ); ?>
      </div>
     <?php endif; ?>

    
   </div>
   <?php  } ?>
 </div>

<?php
  return ob_get_clean();
 }
}