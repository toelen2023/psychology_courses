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
  
   public function enqueue_admin_assets($hook){
   

    if ( 'settings_page_psychology-courses-settings' === $hook ) {

        wp_enqueue_script(
            'pc-admin-js',
            PC_PLUGIN_URL . '/assets/js/psy-admin.js',
            [],
            PC_VERSION,
            true
        );

    }
   }

}