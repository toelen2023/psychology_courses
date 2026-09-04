<?php

defined( 'ABSPATH' ) || exit;

class PC_Loader {

    /**
     * Запуск плагина.
     *
     * @return void
     */
    public function run(): void {

        $this->load_files();

        $this->register_classes();

    }

    /**
     * Подключение файлов.
     *
     * @return void
     */
    private function load_files(): void {

        require_once PC_PLUGIN_PATH . 'includes/constants.php';
        require_once PC_PLUGIN_PATH . 'includes/helper-functions.php';
        require_once PC_PLUGIN_PATH . 'includes/class-assets.php';
        require_once PC_PLUGIN_PATH . 'includes/admin/class-admin-assets.php';
        //Plugin settings page
        require_once PC_PLUGIN_PATH . 'includes/admin/class-plugin-settings.php';
        //Course
        require_once PC_PLUGIN_PATH . 'includes/taxonomies/class-course-category-taxonomy.php';
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-course-post-type.php';
        require_once PC_PLUGIN_PATH . 'includes/metaboxes/class-course-metabox.php';
        require_once PC_PLUGIN_PATH . 'includes/save/class-course-save.php';
        require_once PC_PLUGIN_PATH . 'includes/shortcodes/class-course-cards-shortcode.php';
        //stream & schedule
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-course-stream-post-types.php';
        require_once PC_PLUGIN_PATH . 'includes/metaboxes/class-course-schedule-metabox.php';
        require_once PC_PLUGIN_PATH . 'includes/save/class-course-schedule-save.php';
        require_once PC_PLUGIN_PATH . 'includes/shortcodes/class-schedule-shortcode.php';
        //teachers
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-teacher-post-type.php';
        require_once PC_PLUGIN_PATH . 'includes/metaboxes/class-teacher-metabox.php';
        require_once PC_PLUGIN_PATH . 'includes/save/class-teacher-save.php';
        require_once PC_PLUGIN_PATH . 'includes/shortcodes/class-teacher-slider-shortcode.php';

        //Reviews
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-review-post-type.php';

        //all templates pathes
        require_once PC_PLUGIN_PATH . 'includes/template/class-template-loader.php';

    }

    /**
     * Регистрация классов.
     *
     * @return void
     */
    private function register_classes(): void {

    //Course Post type
        ( new PC_Course_Post_Type() )->register();
        ( new PC_Course_Category_Taxonomy() )->register();
        ( new PC_Course_Metabox())->register();
        ( new PC_Course_Save() )->register();
        $course_card_shortcode =  new PC_Course_Cards_Shortcode();
        ( new PC_Course_Stream_Post_Type() )->register();
        ( new PC_Schedule_Metabox() )->register();
        ( new PC_Course_Schedule_Save() )->register();
        ( new PC_Schedule_Shortcode() )->register();
        //Teacher Post type
        ( new PC_Teacher_Post_Type() )->register();
        ( new PC_Teacher_Metabox() )->register();
        ( new PC_Teacher_Save() )->register();
        ( new PC_Teacher_Slider_Shortcode() )->register();

    
        // ( new PC_Review_Post_Type() )->register(); 

        //load & show templates
       ( new PC_Template_Loader() )->register();

       ( new PC_Assets() )->register();
       ( new PC_Admin_Assets() )->register();
       //Plugin settings
       new PC_Plugin_Settings();

    }

}