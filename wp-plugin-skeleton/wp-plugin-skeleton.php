<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Wp_Plugin_Skeleton
 *
 * @wordpress-plugin
 * Plugin Name:       Wp Plugin Skeleton
 * Description:       Wp Plugin Skeleton
 * Version:           1.0.0
 * Author:            Anka Bajurin Stiskalov
 * Text Domain:       wp-plugin-skeleton
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_PLUGIN_SKELETON_VERSION', '1.0.0' );
define( 'WP_PLUGIN_SKELETON_PLUGIN_ID', 'wp_plugin_skeleton' );
define( 'WP_PLUGIN_SKELETON_VERSION_KEY', 'wp_plugin_skeleton_version' );
define( 'WP_PLUGIN_SKELETON_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_PLUGIN_SKELETON_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_PLUGIN_SKELETON_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );

require WP_PLUGIN_SKELETON_PATH . 'vendor/autoload.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
$plugin = Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_service();
$plugin->run();