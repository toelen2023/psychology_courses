<?php
/**
 * Course metaboxes.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Course_Metabox {

 /**
  * Register hooks.
  * @return void
  */
 public function register(): void {

  add_action(
   'add_meta_boxes',
   array( $this, 'add_meta_boxes' )
  );

 }

 /**
  * Register metaboxes.
  * @return void
  */
 public function add_meta_boxes(): void {

  add_meta_box(
   'pc_course_details',
   __( 'Course Details', 'psychology-courses' ),
   array( $this, 'render_course_details' ),
   'course',
   'normal',
   'default'
  );

   add_meta_box(
    'pc_course_teachers',
    __( 'Teachers', 'psychology-courses' ),
    array( $this, 'render_course_teachers' ),
    'course',
    'side',
    'default'
   );

 }

 /**
  * Render metabox.
  *
  * @param WP_Post $post Current post.
  *
  * @return void
  */
 public function render_course_details( WP_Post $post ): void {

  wp_nonce_field(
   'pc_course_save',
   'pc_course_nonce'
  );

  $duration = get_post_meta(
   $post->ID,
   pc_get_duration_meta_key(),
   true
  );

  $prices = pc_get_course_prices( $post->ID );

  $short_title = get_post_meta( $post->ID, 'pc_course_short_title', true );

  ?>

  <table class="form-table" role="presentation">
   <tbody>
    <tr>
     <th scope="row">

      <label for="pc_duration">
       <?php esc_html_e( 'Duration', 'psychology-courses' ); ?>
      </label>
     </th>
     <td>
      <select
       name="pc_duration"
       id="pc_duration">

       <option value="">

        <?php esc_html_e( 'Select duration', 'psychology-courses' ); ?>

       </option>

       <?php for ( $i = 1; $i <= PC_MAX_MONTHS; $i++ ) : ?>

        <option
         value="<?php echo esc_attr( $i ); ?>"
         <?php selected( $duration, $i ); ?>
        >

         <?php
         printf(
          esc_html(
           _n('%d month','%d months',
            $i,
            'psychology-courses')
          ),
          $i
         );
         ?>
        </option>

       <?php endfor; ?>

      </select>
     </td>
     <th scope="row">

      <label for="pc_course_short_title">
       <?php esc_html_e( 'Course short title', 'psychology-courses' ); ?>
      </label>
     </th>
     <td>
      <input type="text" 
        id="pc_course_short_title" 
        name="pc_course_short_title"
        class="regular-text"
        placeholder="КПТ, Практична психологія"
        value="<?php echo esc_html( $short_title ); ?>">
    </td>
    </tr>
   </tbody>
  </table>

  <h3>

   <?php esc_html_e(
    'Course Price',
    'psychology-courses'
   ); ?>

  </h3>

  <table class="widefat striped">

   <thead>
    <tr>
     <th><?php esc_html_e( 'Currency', 'psychology-courses' ); ?></th>
     <th><?php esc_html_e( 'Full price', 'psychology-courses' ); ?></th>
     <th><?php esc_html_e( 'Monthly payment', 'psychology-courses' ); ?></th>
    </tr>
   </thead>

   <tbody>

    <?php foreach ( pc_get_currencies() as $code => $label ) : ?>

     <?php

     $full_price  = $prices[ $code ]['full'] ?? '';
     $month_price = $prices[ $code ]['month'] ?? '';

     ?>

     <tr>
      <td>
       <strong><?php echo esc_html( $label ); ?></strong>
      </td>
      <td>
       <input
        type="number"
        name="pc_prices[<?php echo esc_attr( $code ); ?>][full]"
        value="<?php echo esc_attr( $full_price ); ?>"
        min="0"
        step="0.01"
        class="regular-text">
      </td>
      <td>
       <input
        type="number"
        name="pc_prices[<?php echo esc_attr( $code ); ?>][month]"
        value="<?php echo esc_attr( $month_price ); ?>"
        min="0"
        step="10"
        class="regular-text">
      </td>
     </tr>

    <?php endforeach; ?>

   </tbody>
  </table>

  <?php

 }
/**
 * Render teachers metabox.
 * @param WP_Post $post Current post.
 * @return void
 */
public function render_course_teachers( WP_Post $post ): void {

$selected_teachers = get_post_meta( $post->ID,
    pc_get_course_teachers_meta_key(), true );

if ( ! is_array( $selected_teachers ) )  $selected_teachers = array();

$teachers = get_posts(
    array(
    'post_type'      => 'teacher',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    )
);

if ( empty( $teachers ) ) {
    esc_html_e('No teachers available.', 'psychology-courses' );
    return;
}

?>

<div class="pc-course-teachers">

<?php foreach ( $teachers as $teacher ) : ?>
  <p>
    <label>
     <input
        type="checkbox"
        name="pc_course_teachers[]"
        value="<?php echo esc_attr( $teacher->ID ); ?>"
        <?php checked( in_array( $teacher->ID, $selected_teachers, true ) ); ?>>

    <?php echo esc_html( $teacher->post_title ); ?>
    </label>
    </p>

    <?php endforeach; ?>
    </div>

    <?php
  }
}