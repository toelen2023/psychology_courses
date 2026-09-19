<?php
/**
 * Content Teacher template.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$teacher_id = get_the_ID();
$consult_price = get_post_meta( $teacher_id, pc_get_consultation_price_meta_key(), true );
$content = get_the_content(null, null, $teacher_id);
?>

<section class="pc-teacher-item">
    
    <div class="entry-content d-flex-between" itemprop="text">
        <div class="pc-teacher-intro column-1-4">
              <?php if ( has_post_thumbnail() ) : ?>
            <div class="pc-teacher-image">
                <?php
                the_post_thumbnail('medium',
                    array('alt' => get_the_title(),  )
                );
                ?>
            </div>
          <?php endif; ?>
            <header class="entry-header pt-20">
                <?php  if ( is_singular( 'teacher' ) ) :?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php else: ?>
                <h2 class="entry-title"><?php the_title(); ?></h2>
                <?php endif; ?>
            </header>          
        </div><!--/end .column-1-4-->
        <div class="pc-teacher-content column-3-4" itemprop="text">
            <?php echo $content; ?>
        
            <div class="pc-teacher-info d-flex-between" itemprop="text">         
                <div class="column-1-2">
                    <?php pc_get_template_part('teacher/parts/teacher-courses'); ?>
                </div>

                <div class="column-1-2">
                    <p><strong><?php  _e( 'Consultation Price', 'psychology-courses' ) ?> <?php echo  $consult_price ?> грн.</strong></p>
                    <?php
                    echo do_shortcode('[cf7ip_button form_id="081af97" text="'. __("Sign Up for a consultation", 'psychology-courses' ) .'" title="'. __("Sign Up for a consultation", 'psychology-courses' ) .'" animation="fade" teacher="' .get_the_title(). '"]');
                    ?>
                </div>    
            </div>
      </div>
    </div><!--/.d-flex-between -->
                    
</section>