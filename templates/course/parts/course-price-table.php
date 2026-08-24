<?php
/**
 * Course price table template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

$prices = pc_get_course_prices( get_the_ID() );
?>

<table>
 <tbody>

    <?php 
   

    foreach ( pc_get_currencies() as $code => $label ) : ?>

        <?php
            $full  = $prices[ $code ]['full'] ?? '';
            $month = $prices[ $code ]['month'] ?? '';
        ?>

        <tr>
            <th><?php echo esc_html( $label ); ?></th>
            <td><?php echo esc_html( $full ); ?></td>
            <td><?php echo esc_html( $month ); ?></td>
        </tr>

    <?php endforeach; ?>

 </tbody>
</table>