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

use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;

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
        if (\defined('WP_PLUGIN_SKELETON_VERSION')) {
            $this->version = WP_PLUGIN_SKELETON_VERSION;
        } else {
            $this->version = '1.0.0';
        }
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
    }


    /**
     * Updates version in database
     *
     * @since    1.0.0
     * @access   private
     */
    private function update_version(): void
    {
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
        $this->wp_plugin_skeleton_i18n = Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_i18n();
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

}