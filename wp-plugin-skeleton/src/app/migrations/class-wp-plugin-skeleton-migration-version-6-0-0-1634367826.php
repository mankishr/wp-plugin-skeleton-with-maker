<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Version_6_0_0_1634367826 class.
 *
 * This class handles database migration from older version to version 6.0.0.
 *
 * @since      6.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Migrations
 */

namespace Wp_Plugin_Skeleton\Migrations;

use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;

/**
 * Class Wp_Plugin_Skeleton_Version_6_0_0_1634367826
 *
 * Handles database table migration for plugin version 6.0.0.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Command
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Version_6_0_0_1634367826 extends Wp_Plugin_Skeleton_Database_Migration {

	/**
	 * Custom product ratings db table name.
	 *
	 * @var string
	 */
    private $scores_table;

    /**
	 * Wp_Plugin_Skeleton_Version_104_1634367826 constructor.
	 *
	 * @param wpdb $db_base WordPress database global instance.
	 *
	 * @since    6.0.0
	 */
	public function __construct( $db_base ) {
		parent::__construct( $db_base );
		$this->scores_table = Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_game_score_repository()->table_name();

	}

	/**
	 * Renames updated_at field into created_at since it is better representation of inserted data.
	 *
	 * @since    6.0.0
	 */
	public function up(): void {
	    $q = "ALTER TABLE {$this->scores_table} ADD COLUMN wp_user_id BIGINT(20) ";
        $this->db->query( $q );
	}
}
