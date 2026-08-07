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

        require_once PC_PLUGIN_PATH . 'includes/post-types/class-course-post-type.php';
       // require_once PC_PLUGIN_PATH . 'includes/post-types/class-course-stream-post-type.php';
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-teacher-post-type.php';
        require_once PC_PLUGIN_PATH . 'includes/post-types/class-review-post-type.php';

        require_once PC_PLUGIN_PATH . 'includes/taxonomies/class-course-category-taxonomy.php';

    }

    /**
     * Регистрация классов.
     *
     * @return void
     */
    private function register_classes(): void {

        ( new PC_Course_Post_Type() )->register();

        // ( new PC_Course_Stream_Post_Type() )->register();

        // ( new PC_Teacher_Post_Type() )->register();

        // ( new PC_Review_Post_Type() )->register();

        // ( new PC_Course_Category_Taxonomy() )->register();

    }

}