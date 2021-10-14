<?php
/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Includes
 */

namespace Wp_Plugin_Skeleton\Includes;

use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/includes
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Deactivator
{

    /**
     * Fired during plugin deactivation.
     *
     * This class defines all code necessary to run during the plugin's deactivation.
     *
     * @since    1.0.0
     */
    public static function deactivate(): void
    {
        Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_game_score_repository()->drop_table();
        delete_option( WP_PLUGIN_SKELETON_VERSION_KEY );
    }
}
