<?php
/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Includes
 */

namespace Wp_Plugin_Skeleton\Includes;

use Wp_Plugin_Skeleton\Admin\Wp_Plugin_Skeleton_Admin_Menu_Page;
use Wp_Plugin_Skeleton\Command\Wp_Plugin_Skeleton_Database_Update;
use Wp_Plugin_Skeleton\Command\Wp_Plugin_Skeleton_Import_Scores_Command;
use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;
use Wp_Plugin_Skeleton\Service\Wp_Plugin_Skeleton_Cron_Service;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Includes
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Service
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Wp_Plugin_Skeleton_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version
     */
    protected $version;

    /**
     * @var string
     */
    private $wp_plugin_skeleton;

    /**
     * @var Wp_Plugin_Skeleton_I18n
     */
    private $wp_plugin_skeleton_i18n;

    /**
     * @var Wp_Plugin_Skeleton_Admin_Menu_Page
     */
    private  $admin_menu_page;

    /**
     * @var Wp_Plugin_Skeleton_Cron_Service
     */
    private $cron_service;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @param Wp_Plugin_Skeleton_Loader $loader Instance of Wp_Plugin_Skeleton_Loader class.
     *
     * @since    1.0.0
     */
    public function __construct( Wp_Plugin_Skeleton_Loader $loader )
    {
        $this->version = WP_PLUGIN_SKELETON_VERSION;

        $this->wp_plugin_skeleton = 'wp-plugin-skeleton';

        $this->loader = $loader;

        $this->load_other_dependencies();
        $this->init();
    }

    /**
     * Initialises all necessary updates, locale and cron jobs.
     */
    private function init(): void
    {
        $this->update_version();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_cron_hooks();
    }

    /**
     * Updates version in database
     *
     * @since    1.0.0
     * @access   private
     */
    private function update_version(): void
    {
        $current_version = get_option( WP_PLUGIN_SKELETON_VERSION_KEY ) ?? '0.0.0';
        if(version_compare($current_version, '3.0.0', '<')){
            $this->install_custom_db_table();
        }else{
            Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_database_update()->execute();
        }

        if( Wp_Plugin_Skeleton_Cron_Service::WP_PLUGIN_SKELETON_MIGRATE_CRON === true && version_compare($current_version, $this->version, '<') ){
            $this->migrate_cron_jobs();
        }
        update_option(WP_PLUGIN_SKELETON_VERSION_KEY, $this->version);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run(): void
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_wp_plugin_skeleton_plugin_name(): string
    {
        return $this->wp_plugin_skeleton;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Wp_Plugin_Skeleton_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader(): Wp_Plugin_Skeleton_Loader
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version(): string
    {
        return $this->version;
    }

    private function load_other_dependencies()
    {
        $this->admin_menu_page = Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_admin_menu_page();
        $this->wp_plugin_skeleton_i18n = Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_i18n();
        $this->cron_service = Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_cron_service();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale(): void {
        $this->loader->add_action( 'plugins_loaded', $this->wp_plugin_skeleton_i18n, 'load_plugin_textdomain' );
    }

    private function define_admin_hooks(): void
    {
        $this->loader->add_action('admin_menu', $this->admin_menu_page, 'add_menu_page');
        $this->loader->add_action('admin_menu', $this->admin_menu_page, 'settings_page_fields');
    }

    private function install_custom_db_table(): void
    {
        Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_game_score_repository()->setup_table();
    }

    /**
     * Migrate cron jobs, change time, order, schedule id and similar.
     *
     * @since    4.0.0
     */
    private function migrate_cron_jobs(): void
    {
        $this->cron_service->cron_deactivation();
        $this->cron_service->cron_activation();
    }

    private function define_cron_hooks(): void
    {
        $this->loader->add_filter('cron_schedules', $this->cron_service, 'cron_schedules');
        $this->loader->add_action('admin_init', $this->cron_service, 'cron_activation', 2);
        $import_scores_command = new Wp_Plugin_Skeleton_Import_Scores_Command();
        $this->loader->add_action(Wp_Plugin_Skeleton_Cron_Service::WP_PLUGIN_SKELETON_CRON_SCHEDULE_ID, $import_scores_command, 'execute', 2);
    }

}
