<?php
/**
 * Course card template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$post_id = isset( $template_args['post_id'] )
 ? absint( $template_args['post_id'] )
 : 0;

if ( ! $post_id ) {
 return;
}

$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );
$thumbnail = get_the_post_thumbnail_url( $post_id, 'medium' );
$excerpt   = get_the_excerpt( $post_id );

$duration = get_post_meta(
 $post_id,
 pc_get_duration_meta_key(),
 true
);
?>

<article class="pc-course-card">

 <?php if ( $thumbnail ) : ?>

  <a
   class="pc-course-card__image"
   href="<?php echo esc_url( $permalink ); ?>"
  >

   <img
    src="<?php echo esc_url( $thumbnail ); ?>"
    alt="<?php echo esc_attr( $title ); ?>"
   >

  </a>

 <?php endif; ?>

 <div class="pc-course-card__content">

  <h2 class="pc-course-card__title">

   <a href="<?php echo esc_url( $permalink ); ?>">

    <?php echo esc_html( $title ); ?>

   </a>

  </h2>

  <?php if ( $duration ) : ?>

   <p class="pc-course-card__duration">

    <strong>
     <?php esc_html_e( 'Duration:', 'psychology-courses' ); ?>
    </strong>

    <?php
    printf(
     esc_html(
      _n(
       '%d month',
       '%d months',
       (int) $duration,
       'psychology-courses'
      )
     ),
     (int) $duration
    );
    ?>

   </p>

  <?php endif; ?>

  <?php if ( $excerpt ) : ?>

   <div class="pc-course-card__excerpt">

    <?php echo wp_kses_post( $excerpt ); ?>

   </div>

  <?php endif; ?>

  <a
   class="pc-course-card__link"
   href="<?php echo esc_url( $permalink ); ?>"
  >

   <?php esc_html_e( 'Подробнее', 'psychology-courses' ); ?>

  </a>

 </div>

</article>