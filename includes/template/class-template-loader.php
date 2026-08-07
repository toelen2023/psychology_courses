<?php
/**
 * Register Course, Teachers, Review Templates.
 *
 * @package Psychology_Courses
 */

class PC_Template_Loader {

    public function register(): void {

        add_filter(
            'template_include',
            array( $this, 'load_template' )
        );

    }

    public function load_template( $template ) {

        if ( is_singular( 'course' ) ) {

            return PC_PLUGIN_DIR . 'templates/single-course.php';

        }

        if ( is_post_type_archive( 'course' ) ) {

            return PC_PLUGIN_DIR . 'templates/archive-course.php';

        }

        return $template;

    }

}
