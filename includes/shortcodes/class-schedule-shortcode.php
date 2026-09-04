<?php

/**
 * Schedule shortcode.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Schedule_Shortcode {

 /**
  * Register shortcode.
  *
  * @return void
  */
 public function register(): void {

  add_shortcode(
   'schedule',
   array( $this, 'render' )
  );
 }

 /**
  * Render schedule.
  *
  * Usage:
  * [schedule month="10" year="2026"]
  *
  * @param array $atts Shortcode attributes.
  * @return string
  */
 public function render( $atts ): string {

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

  $rows = get_post_meta(
   $this->get_schedule_post_id(),
   'pc_schedule_rows',
   true
  );

  if ( ! is_array( $rows ) ) {
   return '';
  }

  $rows = array_filter(
   $rows,
   function ( $row ) use ( $month, $year ) {

    if ( empty( $row['date'] ) ) {
     return false;
    }

    $timestamp = strtotime( $row['date'] );

    if ( ! $timestamp ) {
     return false;
    }

    if ( $month && (int) gmdate( 'n', $timestamp ) !== $month ) {
     return false;
    }

    if ( $year && (int) gmdate( 'Y', $timestamp ) !== $year ) {
     return false;
    }

    return true;
   }
  );

  if ( empty( $rows ) ) {
   return '';
  }

  usort(
   $rows,
   function ( $a, $b ) {

    $date_a = ( $a['date'] ?? '' ) . ' ' . ( $a['time'] ?? '' );
    $date_b = ( $b['date'] ?? '' ) . ' ' . ( $b['time'] ?? '' );

    return strcmp( $date_a, $date_b );
   }
  );

  ob_start();

  ?>

  <div class="pc-schedule">

   <?php foreach ( $rows as $row ) : ?>

    <?php
    $icon_id = isset( $row['icon_id'] )
     ? absint( $row['icon_id'] )
     : 0;

    $course_name = isset( $row['course_name'] )
     ? $row['course_name']
     : '';

    $teacher_name = isset( $row['teacher_name'] )
     ? $row['teacher_name']
     : '';

    $date = isset( $row['date'] )
     ? $row['date']
     : '';

    $time = isset( $row['time'] )
     ? $row['time']
     : '';

    $stream = isset( $row['stream'] )
     ? absint( $row['stream'] )
     : 0;

    $duration = isset( $row['duration'] )
     ? absint( $row['duration'] )
     : 0;

    $lessons = isset( $row['lessons'] )
     ? absint( $row['lessons'] )
     : 0;

    $registration = isset( $row['registration'] )
     ? $row['registration']
     : '';
    ?>

    <div class="pc-schedule-course">

     <?php if ( $icon_id ) : ?>

      <div class="pc-schedule-course__icon">
       <?php
       echo wp_get_attachment_image(
        $icon_id,
        'thumbnail'
       );
       ?>
      </div>

     <?php endif; ?>

     <div class="pc-schedule-course__content">

      <?php if ( $course_name ) : ?>

       <h3 class="pc-schedule-course__title">
        <?php echo esc_html( $course_name ); ?>
       </h3>

      <?php endif; ?>

      <?php if ( $stream ) : ?>

       <div class="pc-schedule-course__stream">
        <?php
        printf(
         /* translators: %d: stream number */
         esc_html__( 'Stream %d', 'psychology-courses' ),
         $stream
        );
        ?>
       </div>

      <?php endif; ?>

      <div class="pc-schedule-course__date">

       <?php
       echo esc_html(
        wp_date(
         get_option( 'date_format' ),
         strtotime( $date )
        )
       );
       ?>

       <?php if ( $time ) : ?>

        <span class="pc-schedule-course__time">
         <?php echo esc_html( $time ); ?>
        </span>

       <?php endif; ?>

      </div>

      <?php if ( $teacher_name ) : ?>

       <div class="pc-schedule-course__teacher">
        <?php echo esc_html( $teacher_name ); ?>
       </div>

      <?php endif; ?>

      <?php if ( $duration || $lessons ) : ?>

       <div class="pc-schedule-course__details">

        <?php if ( $duration ) : ?>

        <span>
          <?php
          printf(
           esc_html(
            _n(
             '%d month',
             '%d months',
             $duration,
             'psychology-courses'
            )
           ),
           $duration
          );
          ?>
         </span>

        <?php endif; ?>

        <?php if ( $lessons ) : ?>

         <span>
          <?php
          printf(
           esc_html(
            _n(
             '%d lesson',
             '%d lessons',
             $lessons,
             'psychology-courses'
            )
           ),
           $lessons
          );
          ?>
         </span>

        <?php endif; ?>

       </div>

      <?php endif; ?>

      <?php if ( $registration ) : ?>

       <div class="pc-schedule-course__registration">
        <?php
        echo do_shortcode( $registration );
        ?>
       </div>

      <?php endif; ?>

     </div>

    </div>

   <?php endforeach; ?>

  </div>

  <?php

  return ob_get_clean();
 }

 /**
  * Get schedule post ID.
  *
  * @return int
  */
 private function get_schedule_post_id(): int {

  $posts = get_posts(
   array(
    'post_type'      => 'course-stream',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
   )
  );

  if ( empty( $posts ) ) {
   return 0;
  }

  return (int) $posts[0]->ID;
 }
}