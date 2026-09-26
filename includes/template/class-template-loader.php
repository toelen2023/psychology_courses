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

        // course templates
        if ( is_singular( 'course' ) )
            return PC_PLUGIN_PATH . 'templates/course/single-course.php';

        if ( is_post_type_archive( 'course' ) ) 
            return PC_PLUGIN_PATH . 'templates/course/archive-course.php';
        // teachers templates
        if ( is_singular( 'teacher' ) ) 
            return PC_PLUGIN_PATH . 'templates/teacher/single-teacher.php';

        if ( is_post_type_archive( 'teacher' ) ) 
            return PC_PLUGIN_PATH . 'templates/teacher/archive-teacher.php';
        //reviews template
        if ( is_singular( 'review' ) ) 
            return PC_PLUGIN_PATH . 'templates/review/single-review.php';

        if ( is_post_type_archive( 'review' ) ) 
            return PC_PLUGIN_PATH . 'templates/review/archiv-review.php';

        return $template;

    }

}
