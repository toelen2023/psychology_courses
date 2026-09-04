<?php
/**
 * Course card filter.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;
$course_categories = get_terms(
 array(
  'taxonomy'   => 'course_category',
  'hide_empty' => true,
  'order' => 'DESC',
 )
);

?>
<div class="pc-course-filters" style="margin-bottom: 15px;">
    <button type="button" class="pc-course-filter is-active" data-filter="all">
    <?php _e( 'All courses', 'psychology-courses' ); ?></button>

    <?php if ( ! empty( $course_categories ) && ! is_wp_error( $course_categories ) ) : ?>

    <?php foreach ( $course_categories as $category ) : ?>

    <button type="button" class="pc-course-filter"
        data-filter="<?php echo esc_attr( $category->slug ); ?>">
        <?php echo esc_html( $category->name ); ?>
    </button>

    <?php endforeach; ?>

    <?php endif; ?>

</div>