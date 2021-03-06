<?php
/**
 * The Wp_Plugin_Skeleton_Service_Container class handles initialisation of all services in the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Infrastructure
 */

namespace Wp_Plugin_Skeleton\Infrastructure;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Wp_Plugin_Skeleton\Admin\Wp_Plugin_Skeleton_Admin_Menu_Page;
use Wp_Plugin_Skeleton\Admin\Settings\Wp_Plugin_Skeleton_Settings_Service;
use Wp_Plugin_Skeleton\Command\Wp_Plugin_Skeleton_Database_Update;
use Wp_Plugin_Skeleton\Factory\Wp_Plugin_Skeleton_Game_Score_Factory;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Activator;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Deactivator;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_I18n;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Loader;
use Wp_Plugin_Skeleton\Includes\Wp_Plugin_Skeleton_Service;
use Wp_Plugin_Skeleton\Repository\Wp_Plugin_Skeleton_Game_Score_Repository;
use Wp_Plugin_Skeleton\Service\Wp_Plugin_Skeleton_Cron_Service;
use Wp_Plugin_Skeleton\Service\Wp_Plugin_Skeleton_Game_Scores_Service;


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
     * @var  Wp_Plugin_Skeleton_Service_Container|null
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

    /**
     * @var Wp_Plugin_Skeleton_Settings_Service
     */
    private $wp_plugin_skeleton_settings_service;

    /**
     * @var Wp_Plugin_Skeleton_Admin_Menu_Page
     */
    private $wp_plugin_skeleton_admin_menu_page;

    /**
     * @var Wp_Plugin_Skeleton_Game_Score_Repository
     */
    private $wp_plugin_skeleton_game_score_repository;

    /**
     * @var Wp_Plugin_Skeleton_Game_Score_Factory
     */
    private $wp_plugin_skeleton_game_score_factory;

    /**
     * @var Wp_Plugin_Skeleton_Cron_Service
     */
    private $wp_plugin_skeleton_cron_service;

    /**
     * @var Wp_Plugin_Skeleton_Game_Scores_Service
     */
    private $wp_plugin_skeleton_scores_service;

    /**
     * @var ValidatorInterface|RecursiveValidator
     */
    private $wp_plugin_skeleton_validator;

    /**
     * @var Wp_Plugin_Skeleton_Database_Update
     */
    private  $wp_plugin_skeleton_database_update;

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

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Settings_Service object.
     *
     * @return Wp_Plugin_Skeleton_Settings_Service
     *
     * @since    2.0.0
     */
    public function wp_plugin_skeleton_settings_service(): Wp_Plugin_Skeleton_Settings_Service
    {
        if (null === $this->wp_plugin_skeleton_settings_service) {
            $this->wp_plugin_skeleton_settings_service = new Wp_Plugin_Skeleton_Settings_Service();
        }
        return $this->wp_plugin_skeleton_settings_service;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Admin_Menu_Page object.
     *
     * @return Wp_Plugin_Skeleton_Admin_Menu_Page
     *
     * @since    2.0.0
     */
    public function wp_plugin_skeleton_admin_menu_page(): Wp_Plugin_Skeleton_Admin_Menu_Page
    {
        if (null === $this->wp_plugin_skeleton_admin_menu_page) {
            $this->wp_plugin_skeleton_admin_menu_page = new Wp_Plugin_Skeleton_Admin_Menu_Page($this->wp_plugin_skeleton_settings_service());
        }
        return $this->wp_plugin_skeleton_admin_menu_page;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Custom_Table_Repository object.
     *
     * @return Wp_Plugin_Skeleton_Game_Score_Repository
     *
     * @since    3.0.0
     */
    public function wp_plugin_skeleton_game_score_repository(): Wp_Plugin_Skeleton_Game_Score_Repository
    {
        if (null === $this->wp_plugin_skeleton_game_score_repository) {
            global $wpdb;
            $this->wp_plugin_skeleton_game_score_repository = new Wp_Plugin_Skeleton_Game_Score_Repository($wpdb, 'game_score');
        }
        return $this->wp_plugin_skeleton_game_score_repository;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Game_Score_Factory object.
     *
     * @return Wp_Plugin_Skeleton_Game_Score_Factory
     *
     * @since    4.0.0
     */
    public function wp_plugin_skeleton_game_score_factory(): Wp_Plugin_Skeleton_Game_Score_Factory
    {
        if (null === $this->wp_plugin_skeleton_game_score_factory) {
            $this->wp_plugin_skeleton_game_score_factory = new Wp_Plugin_Skeleton_Game_Score_Factory();
        }
        return $this->wp_plugin_skeleton_game_score_factory;
    }

    /**
     * Creates and returns new Wp_Plugin_Skeleton_Cron_Service object.
     *
     * @return Wp_Plugin_Skeleton_Cron_Service
     *
     * @since    5.0.0
     */
    public function wp_plugin_skeleton_cron_service(): Wp_Plugin_Skeleton_Cron_Service
    {
        if (null === $this->wp_plugin_skeleton_cron_service) {
            $this->wp_plugin_skeleton_cron_service = new Wp_Plugin_Skeleton_Cron_Service();
        }
        return $this->wp_plugin_skeleton_cron_service;
    }

    /**
     * Creates and returns new ValidatorInterface object.
     *
     * @return ValidatorInterface
     *
     * @since    1.0.2
     */
    public function wp_plugin_skeleton_validator(): ValidatorInterface {
        if ( null === $this->wp_plugin_skeleton_validator ) {
            $this->wp_plugin_skeleton_validator = Validation::createValidatorBuilder()
                ->addMethodMapping('loadValidatorMetadata')
                ->getValidator();
        }
        return $this->wp_plugin_skeleton_validator;
    }

    /**
     * @return Wp_Plugin_Skeleton_Game_Scores_Service
     *
     * @since    5.0.0
     */
    public function wp_plugin_skeleton_scores_service(): Wp_Plugin_Skeleton_Game_Scores_Service
    {
        if (null === $this->wp_plugin_skeleton_scores_service) {
            $this->wp_plugin_skeleton_scores_service = new Wp_Plugin_Skeleton_Game_Scores_Service($this->wp_plugin_skeleton_game_score_repository(), $this->wp_plugin_skeleton_game_score_factory(), $this->wp_plugin_skeleton_validator());
        }
        return $this->wp_plugin_skeleton_scores_service;
    }

    /**
     * @return Wp_Plugin_Skeleton_Database_Update
     *
     * @since    6.0.0
     */
    public function wp_plugin_skeleton_database_update(): Wp_Plugin_Skeleton_Database_Update
    {
        if (null === $this->wp_plugin_skeleton_database_update) {
            global $wpdb;
            $this->wp_plugin_skeleton_database_update = new Wp_Plugin_Skeleton_Database_Update($wpdb);
        }
        return $this->wp_plugin_skeleton_database_update;
    }
}