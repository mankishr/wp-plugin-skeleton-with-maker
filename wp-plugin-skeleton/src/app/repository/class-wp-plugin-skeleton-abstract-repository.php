<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Abstract_Repository class
 *
 * A class that handles saving and retrieving data from custom database table.
 *
 * @since      3.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Repository
 */

namespace Wp_Plugin_Skeleton\Repository;

/**
 * Class Wp_Plugin_Skeleton_Abstract_Repository
 *
 * A class that handles saving and retrieving data from database.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Repository
 * @author     Anka Bajurin Stiskalov
 */
abstract class Wp_Plugin_Skeleton_Abstract_Repository {

	/**
	 * WordPress database global instance.
	 *
	 * @var wpdb
	 */
	protected $db;

	/**
	 * Custom db table name.
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * String with plugin version.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Wp_Plugin_Skeleton_Database constructor.
	 *
	 * @param wpdb   $db_base WordPress database global instance.
	 * @param string $table Database table name.
	 *
	 * @since    3.0.0
	 */
	public function __construct( $db_base, string $table ) {
		$this->db = $db_base;

		$this->table = $this->db->prefix . $table;

		$this->version = 'v' . WP_PLUGIN_SKELETON_VERSION;
	}

	/**
	 * Force extending class to create custom table.
	 */
	abstract public function setup_table();

    /**
     * Gets table name with prefix.
     *
     * @return string
     *
     * @since    5.0.0
     */
    public function table_name(): string{
        return $this->table;
    }

	 /**
	  * Retrieves all data for the table.
	  *
	  * @return array
	  *
	  * @since    3.0.0
	  */
	public function all(): array {
		$results   = $this->db->get_results( "SELECT * FROM {$this->table}", ARRAY_A );
		$flattened = array();
		foreach ( $results as $name => $value ) {
			$flattened[ $name ] = $value;
		}
		return $flattened;
	}

	/**
	 * Updates table in the database with new values.
	 *
	 * @param array $to_update Array of data for an UPDATE query request.
	 * @return mixed
	 *
	 * @since    3.0.0
	 */
	public function update( array $to_update ) {
		if ( ! isset( $to_update['id'] ) ) {
			return false;
		}

		$id = $to_update['id'];
        unset( $to_update['id'] );

		return $this->db->update( $this->table, $to_update, array( 'id' => $id ), array( '%s', '%s' ) );
	}


	/**
	 * Replace row in table in the database with new values.
	 *
	 * @param array $to_update Array of data for an UPDATE query request.
	 * @return mixed
	 *
	 * @since    3.0.0
	 */
	public function replace( array $to_update ) {
		return $this->db->replace( $this->table, $to_update, array( '%s', '%s' ) );
	}

	/**
	 * Deletes row in the database.
	 *
	 * @param array $where Array with values to match for an DELETE query request.
	 * @return mixed
	 *
	 * @since    3.0.0
	 */
	public function delete( array $where ) {
		return $this->db->delete( $this->table, $where );
	}

	/**
	 * Inserts row into database.
	 *
	 * @param array $arguments Array of values that needs to be inserted into database row.
	 * @return mixed
	 *
	 * @since    3.0.0
	 */
	public function insert( array $arguments ) {
		return $this->db->insert( $this->table, $arguments );
	}

	/**
	 * Drops table from the database.
	 *
	 * @return mixed
	 *
	 * @since    3.0.0
	 */
	public function drop_table() {
		return $this->db->query( "DROP TABLE IF EXISTS {$this->table}" );
	}

	/**
	 * Get string with escaped values delimited by comma.  Add single quotes for string values for IN SQL clause
	 *
	 * @param array $values Unique id for the product.
	 * @return string escaped string delimited by comma that is ready for IN SQL clause.
	 *
	 * @since    3.0.0
	 */
	public function get_sql_escaped_values_for_in_clause( array $values ): string
    {

		$values = array_map(static function($value ) {

            if (is_numeric( $value)) {
                return (int) esc_sql( $value);
            }

            if (is_string( $value) && '' !== $value) {
                return "'" . trim( esc_sql($value)) . "'";
            }

            if('' === $value) {
                return '';
            }

            return  "'" . trim(esc_sql($value)) . "'";

        }, $values);

		return implode(',', $values);
	}
}
