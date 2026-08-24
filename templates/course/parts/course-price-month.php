<?php
/**
 * Course price table template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$prices = pc_get_course_prices( get_the_ID() );
?>
<p><strong>
    <?php esc_html_e( 'Price', 'psychology-courses' ); ?>
    <?php 
   

    foreach ( pc_get_currencies() as $code => $label ) : ?>

        <?php
           // $full  = $prices[ $code ]['full'] ?? '';
            $month = $prices[ $code ]['month'] ?? '';
        ?>

        
        <?php echo  esc_html( $month )." ".esc_html( $label ) ."/"; ?>
        
    <?php endforeach; ?>

    <?php esc_html_e( ' per month', 'psychology-courses' ); ?>
</p>
