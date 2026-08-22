<?php
/**
 * Teacher card.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_id = get_the_ID();

$consultation_price = get_post_meta( $teacher_id, pc_get_consultation_price_meta_key(), true);
$teacher_excerpt = get_the_excerpt($teacher_id);
?>

<div class="pc-teacher-card">

 <?php if ( has_post_thumbnail() ) : ?>

  <div class="pc-teacher-card-image">

   <a href="<?php the_permalink(); ?>" title="<?php esc_html_e('More','psychology-courses');
   ?>">

    <?php the_post_thumbnail( 'medium' ); ?>

   </a>

  </div>

 <?php endif; ?>
 
 <div class="pc-teacher-card-content">

    <h3><?php the_title(); ?></h3>
    <p><?php pc_get_template_part('teacher/parts/teacher-courses-shortlist'); ?></p>
    <div>
        <?php echo wp_kses_post($teacher_excerpt); ?>
    </div>
    
    
    
 </div>

</div>