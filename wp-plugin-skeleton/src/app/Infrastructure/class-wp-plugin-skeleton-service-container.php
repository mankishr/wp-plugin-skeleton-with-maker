<?php
/**
 * The Wp_Plugin_Skeleton_Service_Container class handles initialisation of all services in the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Infrastructure
 */

namespace Wp_Plugin_Skeleton\Infrastructure;

use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Activator;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Deactivator;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_I18n;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Loader;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Service;

/**
 * Initialise all needed services.
 *
 * Services are called over Service Container:
 * - to prevent reinitialisation if service is already initialised
 * - to setup dependencies so you don't have to worry about them when you need some service that has it's own dependencies
 * - to make access to the services much easier and faster
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Infrastructure
 * @author     Anka Bajurin Stiskalov
 */
final class Wp_Plugin_Skeleton_Service_Container
{
    /**
     * Instance of the Wp_Plugin_Skeleton_Service_Container class.
     *
     * @var  Wp_Plugin_Skeleton_Service_Container
     */
    protected static $instance;

    /**
     * @var Wp_Plugin_Skeleton_Service
     */
    private $wp_plugin_skeleton_service;

    /**
     * @var Wp_Plugin_Skeleton_Loader
     */
    private $wp_plugin_skeleton_loader;

    /**
     * @var Wp_Plugin_Skeleton_I18n
     */
    private $wp_plugin_skeleton_i18n;

    /**
     * @var Wp_Plugin_Skeleton_Activator
     */
    private $wp_plugin_skeleton_activator;

    /**
     * @var Wp_Plugin_Skeleton_Deactivator
     */
    private $wp_plugin_skeleton_deactivator;

    protected function __construct()
    {
    }

    /**
     * Get service container instance
     *
     * @return Wp_Plugin_Skeleton_Service_Container
     *
     * @since    1.0.0
     */
    public static function get_instance(): Wp_Plugin_Skeleton_Service_Container
    {
        if (!self::$instance) {
            self::$instance = new Wp_Plugin_Skeleton_Service_Container();
        }
        return self::$instance;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Loader object.
     *
     * @return Wp_Plugin_Skeleton_Loader
     *
     * @since    1.0.0
     */
    public function wp_plugin_skeleton_loader(): Wp_Plugin_Skeleton_Loader
    {
        if (null === $this->wp_plugin_skeleton_loader) {
            $this->wp_plugin_skeleton_loader = new Wp_Plugin_Skeleton_Loader();
        }
        return $this->wp_plugin_skeleton_loader;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Service object.
     *
     * @return Wp_Plugin_Skeleton_Service
     *
     * @since    1.0.0
     */
    public function wp_plugin_skeleton_service(): Wp_Plugin_Skeleton_Service
    {
        if (null === $this->wp_plugin_skeleton_service) {
            $this->wp_plugin_skeleton_service = new Wp_Plugin_Skeleton_Service(
                $this->wp_plugin_skeleton_loader()
            );
        }
        return $this->wp_plugin_skeleton_service;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_I18n object.
     *
     * @return Wp_Plugin_Skeleton_I18n
     *
     * @since    1.0.0
     */
    public function wp_plugin_skeleton_i18n(): Wp_Plugin_Skeleton_I18n
    {
        if (null === $this->wp_plugin_skeleton_i18n) {
            $this->wp_plugin_skeleton_i18n = new Wp_Plugin_Skeleton_I18n();
        }
        return $this->wp_plugin_skeleton_i18n;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Activator object.
     *
     * @return Wp_Plugin_Skeleton_Activator
     *
     * @since    1.0.0
     */
    public function wp_plugin_skeleton_activator(): Wp_Plugin_Skeleton_Activator
    {
        if (null === $this->wp_plugin_skeleton_activator) {
            $this->wp_plugin_skeleton_activator = new Wp_Plugin_Skeleton_Activator();
        }
        return $this->wp_plugin_skeleton_activator;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Deactivator object.
     *
     * @return Wp_Plugin_Skeleton_Deactivator
     *
     * @since    1.0.0
     */
    public function wp_plugin_skeleton_deactivator(): Wp_Plugin_Skeleton_Deactivator
    {
        if (null === $this->wp_plugin_skeleton_deactivator) {
            $this->wp_plugin_skeleton_deactivator = new Wp_Plugin_Skeleton_Deactivator();
        }
        return $this->wp_plugin_skeleton_deactivator;
    }
}