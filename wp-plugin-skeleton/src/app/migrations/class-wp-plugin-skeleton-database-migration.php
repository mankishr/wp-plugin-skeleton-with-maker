<?php
/**
 * The file that defines abstract class Wp_Plugin_Skeleton_Database_Migration.
 *
 * Each file that extends this abstract class needs to have name with this structure Wp_Plugin_Skeleton_Migration_Version_<version of the plugin without dots>_<current timestamp>
 * for example Wp_Plugin_Skeleton_Migration_Version_1_0_6_1581608458
 * and the file name needs to have structure class-wp-plugin-skeleton-migration-version-<version of the plugin with - instead .>-<current timestamp>.php.
 * In this way when Command/Wp_Plugin_Skeleton_Database_Update is called it will instantiate this class and run it's methods automatically.
 *
 * @since      5.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Migrations
 */

declare(strict_types=1);

namespace Wp_Plugin_Skeleton\Migrations;

/**
 * Abstract class Wp_Plugin_Skeleton_Database_Migration
 *
 * Handles custom database tables migration.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Migrations
 * @author     Anka Bajurin Stiskalov
 */
abstract class Wp_Plugin_Skeleton_Database_Migration {

	/**
	 * WordPress database global instance.
	 *
	 * @var wpdb
	 */
	protected $db;

	/**
	 * Wp_Plugin_Skeleton_Abstract_Migration constructor.
	 *
	 * @param wpdb $db_base WordPress database global instance.
	 *
	 * @since    5.0.0
	 */
	public function __construct( $db_base ) {
		$this->db = $db_base;
	}

    /**
     * Use this method to change table structure.
     *
     * @since    5.0.0
     */
    abstract public function up() : void;

    /**
     * Use this method to remove changes on table structure if something goes wrong during up method call.
     *
     * @since    5.0.0
     */
    public function down() : void {
    }

	/**
	 * Use this method for actions that needs to happen before changing the table structure.
	 *
	 * @since    5.0.0
	 */
	public function pre_up() : void {
	}

	/**
	 * Use this method for actions that needs to happen after changing the table structure.
	 *
	 * @since    5.0.0
	 */
	public function post_up() : void {
	}

	/**
	 * Use this method for actions that need to be executed if something goes wrong during pre_up method call.
	 *
	 * @since    5.0.0
	 */
	public function pre_down() : void {
	}

	/**
	 * Use this method to remove changes on table structure if something goes wrong during post_up method call.
	 *
	 * @since    5.0.0
	 */
	public function post_down() : void {
	}
}
