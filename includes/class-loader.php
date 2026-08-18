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
        //Course
        require_once PC_PLUGIN_PATH . 'includes/taxonomies/class-course-category-taxonomy.php';
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-course-post-type.php';
        require_once PC_PLUGIN_PATH . 'includes/metaboxes/class-course-metabox.php';
        require_once PC_PLUGIN_PATH . 'includes/save/class-course-save.php';

       // require_once PC_PLUGIN_PATH . 'includes/post-types/class-course-stream-post-type.php';
       //teachers
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-teacher-post-type.php';
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-review-post-type.php';


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

        // ( new PC_Course_Stream_Post_Type() )->register();

        ( new PC_Teacher_Post_Type() )->register();

        // ( new PC_Review_Post_Type() )->register(); 

        //load & show templates
       ( new PC_Template_Loader() )->register();

    }

}