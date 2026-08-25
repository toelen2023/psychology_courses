<?php
/**
 * Plugin Name: Psychology Courses
 * Plugin URI:  https://github.com/toelen2023/psychology_courses
 * Description: Plugin for managing psychology courses.
 * Version:     1.0.0
 * Author:      Alex Sha
 * License:     GPL2+
 * Text Domain: psychology-courses
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'PC_PLUGIN_FILE', __FILE__ );
define( 'PC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action('init','pc_load_textdomain');

function pc_load_textdomain(): void {
    load_plugin_textdomain(
        'psychology-courses',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages'
    );
}

require_once PC_PLUGIN_PATH . 'includes/class-loader.php';

$loader = new PC_Loader();
$loader->run();

