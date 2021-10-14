<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Custom_Table_Repository class
 *
 * A class that handles saving and retrieving customer experience from database.
 *
 * @since      3.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage QBestBuy\Repository
 */

namespace Wp_Plugin_Skeleton\Repository;

/**
 * Class Wp_Plugin_Skeleton_Custom_Table_Repository
 *
 * A class that handles saving and retrieving customer experience from database.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Repository
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Game_Score_Repository_Table extends Wp_Plugin_Skeleton_Abstract_Repository
{

    /**
     * Generates new customer experience table for feed's URLs and details.
     *
     * @since    3.0.0
     */
    public function setup_table(): void
    {
        $charset_collate = $this->db->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS `{$this->table}` (
              id BIGINT(20)  NOT NULL AUTO_INCREMENT,
              uuid VARCHAR(190) NOT NULL UNIQUE,
              game_name VARCHAR(190) NOT NULL,
              score DECIMAL(10,2) NOT NULL,
              created_at datetime NULL,
              PRIMARY KEY  (id)
            ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    /**
     * Gets customer experiences from database using category uuid parameter.
     *
     * @return array|null Returns array with customer experience details.
     *
     * @since    3.0.0
     */
    public function get_results_by_uuid(string $uuid): ?array
    {
        $sql = $this->db->prepare("select * from {$this->table} where uuid = %s ", $uuid);
        return $this->db->get_results($sql, ARRAY_A);
    }

    /**
     * Delete cx by uuid.
     *
     * @param string $uuid Uuid of the cx.
     *
     * @since    3.0.0
     */
    public function delete_by_uuid(string $uuid): void
    {
        if ('' === $uuid) {
            return;
        }
        $this->db->query(
            $this->db->prepare(
                "DELETE p
                FROM {$this->table}  p 
                WHERE p.uuid = %s",
                $uuid
            )
        );
    }

}
