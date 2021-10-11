<?php
/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/includes
 */

namespace Wp_Plugin_Skeleton\Includes;


use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/includes
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Activator
{

    /**
     * Fired during plugin activation.
     *
     * This class defines all code necessary to run during the plugin's activation.
     *
     * @since    1.0.0
     */
    public static function activate(): void
    {
        // Remove tables just in case plugin is not deactivated properly.
        Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_custom_table_repository()->drop_table();

        Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_custom_table_repository()->setup_table();
    }
}
