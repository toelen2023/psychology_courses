<?php

if ( ! defined( 'ABSPATH' ) )  exit;


class PC_Admin_Assets {

 public function register() {

  add_action(
    'admin_enqueue_scripts',
    [ $this, 'enqueue_admin_assets' ]
    );

 }
 //Load CSS/JS only on our admin page.
 public function enqueue_admin_assets( $hook ): void {

    if ( 'settings_page_psychology-courses-settings' === $hook ) {
        wp_enqueue_script('pc-admin-js', PC_PLUGIN_URL . '/assets/js/psy-admin.js',
        array(), PC_VERSION, true );
    }

    $screen = get_current_screen();

    if ( $screen  && 'course-stream' === $screen->post_type ) {
        wp_enqueue_media();
        wp_enqueue_script( 'pc-course-schedule-admin',
            PC_PLUGIN_URL . '/assets/js/course-schedule-admin.js',
              array( 'jquery', 'media-editor' ), PC_VERSION, true );
        wp_enqueue_style( 'pc-schedule-admin', PC_PLUGIN_URL . 'assets/css/psy-admin.css',
             array(), PC_VERSION );
    }
  }

}