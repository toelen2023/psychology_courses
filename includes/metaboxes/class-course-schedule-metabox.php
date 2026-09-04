<?php
/**
 * Course Schedule metaboxes.
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

class PC_Schedule_Metabox {

    public function register(): void {
        add_meta_box(
            'pc_schedule',
            __( 'Schedule', 'psychology-courses' ),
            array( $this, 'render' ),
            'schedule',
            'normal',
            'high'
        );
    }

    public function render( WP_Post $post ): void {

        $rows = get_post_meta( $post->ID,'pc_schedule_rows', true  );

        if ( ! is_array( $rows ) )  $rows = array();
      
        wp_nonce_field(
            'pc_schedule_save',
            'pc_schedule_nonce'
        );

        ?>
        <div id="pc-schedule-rows">

            <?php foreach ( $rows as $index => $row ) : ?>

                <?php $this->render_row(  $index, $row);?>

            <?php endforeach; ?>

        </div>

        <button type="button" class="button" id="pc-schedule-add-row">
            <?php esc_html_e( '+ Add stream', 'psychology-courses' ); ?>
        </button>

        <template id="pc-schedule-row-template">

           <?php $this->render_row('INDEX', array());?>

        </template>

        <?php
    }
}