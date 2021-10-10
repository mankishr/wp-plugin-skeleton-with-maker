<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      2.0.0
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin
 */

namespace Wp_Plugin_Skeleton\Admin;

use Wp_Plugin_Skeleton\Admin\Options\Wp_Plugin_Skeleton_Default_Options;
use Wp_Plugin_Skeleton\Admin\Settings\Wp_Plugin_Skeleton_Settings_Service;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Admin
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Admin_Menu_Page {

    /**
     * @var Wp_Plugin_Skeleton_Settings_Service
     */
    private $settings_service;

    public function __construct(Wp_Plugin_Skeleton_Settings_Service $settings_service)
    {
        $this->settings_service = $settings_service;
    }

    public function add_menu_page(): void  {

        add_menu_page(
            __( 'Wp Plugin Skeleton', 'wp-plugin-skeleton' ),
            __( 'Wp Plugin Skeleton', 'wp-plugin-skeleton' ),
            'manage_options',
            'wp-plugin-skeleton-general',
            [ $this, 'display_admin_settings_page'],
            'dashicons-clipboard'
        );
    }

	/**
	 * Function which renders general settings page.
	 */
	public function display_admin_settings_page(): void  {
		require_once WP_PLUGIN_SKELETON_PATH . 'src/views/admin/admin_menu_page.php';
	}

	/**
	 * Register admin sections and fields
	 */
	public function settings_page_fields(): void  {
        $wp_default_options = get_option(Wp_Plugin_Skeleton_Default_Options::wp_option_name()) ?: [];
        $this->settings_service->wp_plugin_skeleton_register_setting_page( new Wp_Plugin_Skeleton_Default_Options( $wp_default_options) );

	}

}
