<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Database_Update class
 *
 * Command that executes database update if the version of the plugin is older than the current one.
 *
 * @since      5.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Command
 */

namespace Wp_Plugin_Skeleton\Command;

use Wp_Plugin_Skeleton\Migrations\Wp_Plugin_Skeleton_Database_Migration;

/**
 * Class Wp_Plugin_Skeleton_Database_Update
 *
 * Command class that executes process for database update.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Command
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Database_Update implements Wp_Plugin_Skeleton_Command
{

    /**
     * WordPress database global instance.
     *
     * @var wpdb
     */
    protected $db;

    /**
     * Current plugins version.
     *
     * @var string
     */
    private $current_version;


    /**
     * Wp_Plugin_Skeleton_Database_Update constructor.
     */
    public function __construct($wpdb)
    {
        $this->db = $wpdb;
        $this->current_version = $this->db->get_var($this->db->prepare("SELECT option_value FROM {$this->db->options} WHERE option_name = %s", WP_PLUGIN_SKELETON_VERSION_KEY));
    }

    /**
     * Executes command for database migration.
     */
    public function execute(): void
    {
        if (version_compare($this->current_version, WP_PLUGIN_SKELETON_VERSION, '>=')) {
            return;
        }

        $path = WP_PLUGIN_SKELETON_PATH . 'src/app/migrations/';
        $directory = new \RecursiveDirectoryIterator($path);
        $iterator = new \RecursiveIteratorIterator($directory);
        $migrations = [];
        foreach ($iterator as $info) {
            $path_name = $info->getPathname();
            if (0 === strpos($path_name, $path . 'class-wp-plugin-skeleton-migration-version-')) {
                $migration = str_replace($path, '', $info->getPathname());
                if (1 === preg_match('/class-wp-plugin-skeleton-migration-version-(.*?)-(.*?)-(.*?)-/', $migration, $match)) {
                    $migration_version = (int)$match[1] . '.' . (int)$match[2] . '.' . (int)$match[3];
                    if (version_compare($this->current_version, $migration_version, '<')) {
                        preg_match("/{$match[0]}(.*?).php/", $migration, $timestamp);
                        $migration_version_alias = str_replace('.', '_', $migration_version);
                        $migrations[(int)$timestamp[1]] = "Wp_Plugin_Skeleton\Migrations\Wp_Plugin_Skeleton_Version_{$migration_version_alias}_{$timestamp[1]}";
                    }
                }
            }
        }
        ksort($migrations);
        foreach ($migrations as $migration_key => $migration) {

            $migration_instance = new $migration($this->db);

            if ($migration_instance instanceof Wp_Plugin_Skeleton_Database_Migration) {
                try {
                    $migration_instance->pre_up();
                    $this->log_in_options($migration_key, 'pre_up', 'SUCCESS');
                } catch (\Exception $e) {
                    $migration_instance->pre_down();
                    $this->log_in_options($migration_key, 'pre_up', 'FAILED');
                }

                try {
                    $migration_instance->up();
                    $this->log_in_options($migration_key, 'up', 'SUCCESS');
                } catch (\Exception $e) {
                    $migration_instance->down();
                    $this->log_in_options($migration_key, 'up', 'FAILED');
                }

                try {
                    $migration_instance->post_up();
                    $this->log_in_options($migration_key, 'post_up', 'SUCCESS');
                } catch (\Exception $e) {
                    $migration_instance->post_down();
                    $this->log_in_options($migration_key, 'post_up', 'FAILED');
                }
            }
        }
    }

    private function log_in_options(string $migration_key, string $method, string $status, string $error_message = ''): void
    {
        $now = date_i18n('F d, Y H:i');

        update_option('wp_plugin_skeleton_last_migration', sprintf("%s! %s->%s Migration key:%s Method:%s %s", $status, $this->current_version, WP_PLUGIN_SKELETON_VERSION, $migration_key, $method, $now));
    }
}
