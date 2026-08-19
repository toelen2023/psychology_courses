<?php
/**
 * Content Teacher template.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_id = get_the_ID();
$consult_price = get_post_meta( $teacher_id, pc_get_consultation_price_meta_key(), true );
?>

<header class="entry-header pc-teacher-header">    
    <h1 class="entry-title"><?php the_title(); ?></h1>
</header>

<div class="entry-content d-flex-between" itemprop="text">
    <div class="pc-teacher-info column-1-4">
        
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="pc-teacher-image">
            <?php
            the_post_thumbnail('medium',
                array('alt' => get_the_title(),  )
            );
            ?>
        </div>
    <?php endif; ?>

        <p><strong><?php  _e( 'Consultation Price', 'psychology-courses' ) ?></strong> <?php echo  $consult_price ?> грн.</p>

        <?php pc_get_template_part('teacher/parts/teacher-courses'); ?>
        <?php 
        echo do_shortcode('[cf7ip_button form_id="081af97" text="'. __("Sign Up for a consultation", 'psychology-courses' ) .'" title="'. __("Sign Up for a consultation", 'psychology-courses' ) .'" animation="fade" teacher="' .get_the_title(). '"]'); 
        ?>
    </div><!--/end .column-1-4-->
    <div class="pc-teacher-content column-3-4" itemprop="text">
        <?php the_content(); ?>    
    </div>
</div><!--/.d-flex-between -->