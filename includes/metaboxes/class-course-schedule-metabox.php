<?php

/**
 * Course Schedule metabox.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Schedule_Metabox {

 /**
  * Register metabox.
  *
  * @return void
  */
 public function register(): void {
    add_action( 'add_meta_boxes',  array( $this, 'add_meta_boxes' ) );
    add_filter('manage_course-stream_posts_columns', array( $this, 'add_shortcode_column' ));

    add_action( 'manage_course-stream_posts_custom_column', array( $this, 'render_shortcode_column' ),  10, 2);
 }
 public function add_meta_boxes(): void {
  add_meta_box( 'pc_schedule',
    __( 'Schedule', 'psychology-courses' ),
    array( $this, 'render' ),
    'course-stream',
    'normal',
    'high'
    );
 }

 /**
  * Render metabox.
  * @param WP_Post $post Current post.
  * @return void
  */
 public function render( WP_Post $post ): void {

  $month = isset( $post->ID ) ? absint( get_post_meta( $post->ID, '_pc_schedule_month', true ) )
 : 0;

  $year = isset( $post->ID ) ? absint( get_post_meta( $post->ID, '_pc_schedule_year', true ) )
 : 0;

  $rows = get_post_meta( $post->ID, 'pc_schedule_rows', true );

  if ( ! is_array( $rows ) )  $rows = array();
  
  wp_nonce_field('pc_schedule_save', 'pc_schedule_nonce' );

  ?>
  <div class="pc-schedule-period">

    <p>
        <label for="pc-schedule-month">
        <strong><?php esc_html_e( 'Месяц:', 'psychology-courses' ); ?></strong>
        </label>

        <input type="number" min="1" max="12" step="1"
        id="pc-schedule-month" name="pc_schedule_month"
        value="<?php echo esc_attr( $month ); ?>">
    </p>

    <p>
        <label for="pc-schedule-year">
            <strong><?php esc_html_e( 'Год:', 'psychology-courses' ); ?></strong>
        </label>

        <input
        type="number" min="2026"  max="2100" step="1"
        id="pc-schedule-year" name="pc_schedule_year"
        value="<?php echo esc_attr( $year ); ?>">
    </p>

  </div>

  <div id="pc-schedule-rows">

   <?php foreach ( $rows as $index => $row ) : ?>

    <?php $this->render_row( $index, $row ); ?>

   <?php endforeach; ?>

  </div>

  <p>
   <button type="button" class="button button-secondary" id="pc-schedule-add-row">
    <?php esc_html_e( '+ Add stream', 'psychology-courses' ); ?>
   </button>
  </p>

  <template id="pc-schedule-row-template">

   <?php $this->render_row('INDEX',array()); ?>

  </template>

  <?php
 }

 /**
  * Render one schedule row.
  * @param string|int $index Row index.
  * @param array       $row Row data.
  * @return void
  */
 private function render_row( $index, array $row ): void {

  $course_id = isset( $row['course_id'] ) ? absint( $row['course_id'] )  : 0;
  
  $stream = isset( $row['stream'] ) ? absint( $row['stream'] ) : 1;

  $date = isset( $row['date'] ) ? sanitize_text_field( $row['date'] ) : '';

  $time = isset( $row['time'] ) ? sanitize_text_field( $row['time'] ) : '';

  $duration = isset( $row['duration'] ) ? absint( $row['duration'] ) : 0;

  $lessons = isset( $row['lessons'] ) ? absint( $row['lessons'] ) : 0;

  $teacher_id = isset( $row['teacher_id'] ) ? absint( $row['teacher_id'] ) : 0;

  $icon_id = isset( $row['icon_id'] ) ? absint( $row['icon_id'] ) : 0;

  $icon_class = isset( $row['icon_class'] )? sanitize_html_class( $row['icon_class'] ) : '';

  $registration = isset( $row['registration'] ) ? $row['registration']  : '';
  

  $courses = get_posts(
   array(
    'post_type'      => 'course',
    'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
   )
  );

  $teachers = get_posts(
   array(
    'post_type'      => 'teacher',
    'post_status'    => array( 'publish', 'draft', 'pending', 'private' ),
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
   )
  );

  ?>

  <div class="pc-schedule-course">
    <div class="pc-schedule-course__handle"> ⋮⋮  ⋮⋮ ⋮⋮</div>
   <div class="pc-schedule-row">

   <div class="pc-schedule-row__field pc-schedule-row__course">

    <label for="pc-schedule-course-select"><?php esc_html_e( 'Course', 'psychology-courses' ); ?></label>
    <select class="pc-schedule-course-select" id="pc-schedule-course-select"
     name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][course_id]">
     <option value=""><?php esc_html_e( 'Select course', 'psychology-courses' ); ?></option>
     
     <?php foreach ( $courses as $course ) : ?>

      <option
       value="<?php echo esc_attr( $course->ID ); ?>"
       <?php selected( $course_id, $course->ID ); ?>>
       <?php echo esc_html( get_the_title( $course ) ); ?>
      </option>

     <?php endforeach; ?>

    </select>

   </div>

   <div class="pc-schedule-row__field">

    <label><?php esc_html_e( 'Stream', 'psychology-courses' ); ?></label>

    <input type="number" min="1" step="1" class="small-text"
     name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][stream]"
     value="<?php echo esc_attr( $stream ); ?>">

   </div>
   <div class="pc-schedule-icon-field">
    <input type="hidden" class="pc-schedule-icon-id"
        name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][icon_id]"
        value="<?php echo esc_attr( $icon_id ); ?>">

    <div class="pc-schedule-icon-preview">
        <?php
        if ( $icon_id ) {
            echo wp_get_attachment_image(  $icon_id,
                'thumbnail', false,
                array(  'style' => 'max-width: 60px; height: auto;',)
            );
        }
        ?>
    </div>

    <button type="button" class="button pc-schedule-icon-upload">
        <?php esc_html_e( 'Choose icon', 'psychology-courses' ); ?>
    </button>

    <button type="button" class="button pc-schedule-icon-remove"
        <?php echo $icon_id ? '' : 'style="display:none;"'; ?>>
        <?php esc_html_e( 'Remove', 'psychology-courses' ); ?>
    </button>
    </div>     
   <div class="pc-schedule-row__field">

    <label>
     <?php esc_html_e( 'Start date', 'psychology-courses' ); ?>
    </label>

    <input type="date" name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][date]"
     value="<?php echo esc_attr( $date ); ?>" class="regular-text">

   </div>

   <div class="pc-schedule-row__field">
    <label><?php esc_html_e( 'Start time', 'psychology-courses' ); ?> </label>

    <input type="time" name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][time]"
     value="<?php echo esc_attr( $time ); ?>" class="regular-text">

   </div>

   <div class="pc-schedule-row__field">

    <label> <?php esc_html_e( 'Duration, months', 'psychology-courses' ); ?> </label>

    <input type="number" min="1" max="<?php echo esc_attr( PC_MAX_MONTHS ); ?>"
     step="1" name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][duration]"
     value="<?php echo esc_attr( $duration ); ?>"  class="small-text">

   </div>

   <div class="pc-schedule-row__field">

    <label><?php esc_html_e( 'Lessons', 'psychology-courses' ); ?></label>

    <input type="number" min="1" step="1"  class="small-text"
     name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][lessons]"
     value="<?php echo esc_attr( $lessons ); ?>">

   </div>

   <div class="pc-schedule-row__field">

    <label><?php esc_html_e( 'Teacher', 'psychology-courses' ); ?></label>

    <select name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][teacher_id]"
     class="pc-schedule-teacher">

     <option value=""><?php esc_html_e( 'Select teacher', 'psychology-courses' ); ?></option>

     <?php foreach ( $teachers as $teacher ) : ?>

      <option
       value="<?php echo esc_attr( $teacher->ID ); ?>"
       <?php selected( $teacher_id, $teacher->ID ); ?>>
       <?php echo esc_html( get_the_title( $teacher ) ); ?>
      </option>

     <?php endforeach; ?>

    </select>

   </div>

   <div class="pc-schedule-row__field">

    <label><?php esc_html_e( 'Icon class', 'psychology-courses' ); ?></label>

    <input type="text" name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][icon_class]"
     value="<?php echo esc_attr( $icon_class ); ?>"
    >

   </div>

   <div class="pc-schedule-row__field pc-schedule-rowfield__registration">

    <label for="pc-schedule-btncode"><?php esc_html_e( 'Registration shortcode', 'psychology-courses' ); ?></label>

    <textarea id="pc-schedule-btncode"
     name="pc_schedule_rows[<?php echo esc_attr( $index ); ?>][registration]"
     rows="3"><?php echo esc_textarea( $registration ); ?></textarea>

    </div>
   </div>
   <div class="pc-schedule-row__actions">

    <button type="button" class="button-link-delete pc-schedule-remove-row"
     title="<?php esc_html_e( 'Remove stream', 'psychology-courses' ); ?>">
     <span class="dashicons dashicons-trash"></span>
    </button>

   </div>

  </div>

  <?php
 }

    public function add_shortcode_column( $columns ): array {

        $columns['pc_shortcode'] = __( 'Shortcode', 'psychology-courses' );
        $columns['pc_main_shortcode'] = __( 'Main shortcode', 'psychology-courses' );

        return $columns;
    }

   public function render_shortcode_column( $column, $post_id ): void {

 if ( ! in_array( $column, array( 'pc_shortcode', 'pc_main_shortcode' ), true ) ) return;
 

 $month = absint( get_post_meta( $post_id, '_pc_schedule_month', true ));

 $year = absint( get_post_meta( $post_id, '_pc_schedule_year', true ) );

 if ( ! $month || ! $year ) { echo '&mdash;'; return; }

 if ( 'pc_shortcode' === $column ) {

  $shortcode = sprintf('[schedule month="%d" year="%d"]', $month, $year );

 } else {

  $shortcode = sprintf('[main_schedule month="%d" year="%d"]',  $month, $year );
 }

 ?>
 <div class="pc-shortcode-copy">

  <input type="text" readonly class="pc-shortcode-copy__input"
   value="<?php echo esc_attr( $shortcode ); ?>"
   onclick="this.select();if ( document.execCommand( 'copy' ) ) this.nextElementSibling.textContent ='✔️ copied';">
  <span class="info"></span>

 </div>
 <?php
}

}