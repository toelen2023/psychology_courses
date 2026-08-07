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

define( 'PC_PLUGIN_FILE', FILE );
define( 'PC_PLUGIN_PATH', plugin_dir_path( FILE ) );
define( 'PC_PLUGIN_URL', plugin_dir_url( FILE ) );

require_once PC_PLUGIN_PATH . 'includes/class-loader.php';

$loader = new PC_Loader();
$loader->run();

