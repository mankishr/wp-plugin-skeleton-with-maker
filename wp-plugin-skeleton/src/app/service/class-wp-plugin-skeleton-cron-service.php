<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Cron_Service class
 *
 * Service class that handles cron jobs.
 *
 * @since      5.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Service
 */

namespace Wp_Plugin_Skeleton\Service;

/**
 * Class Wp_Plugin_Skeleton_Cron_Service
 *
 * Service class that handles and process cron jobs.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Service
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Cron_Service {

    public const WP_PLUGIN_SKELETON_CRON_SCHEDULE_ID = 'wp_plugin_skeleton_schedule';
    public const WP_PLUGIN_SKELETON_MIGRATE_CRON = true;

	/**
	 * Schedule cron job for the feed import from FairerFinances.
	 *
	 * @param array $schedules Array of existing schedules.
	 * @return mixed
	 *
	 * @since    4.0.0
	 */
	public function cron_schedules( array $schedules ): array
    {
        $schedules['every_12_hours'] = [
            'interval' => 43200, // Every 24 hours 86400.
            'display'  => 'Every 12 hours',
        ];
        return $schedules;
	}

	/**
	 * Checks if schedule already exists, if not adds new one.
	 *
	 * @since    4.0.0
	 */
	public function cron_activation(): void {
        if ( ! wp_next_scheduled( self::WP_PLUGIN_SKELETON_CRON_SCHEDULE_ID ) ) {
            wp_schedule_event( strtotime('00:40:00'), 'every_12_hours', self::WP_PLUGIN_SKELETON_CRON_SCHEDULE_ID );
        }
	}

	/**
	 * Removes all schedules related to this plugin.
	 *
	 * @since    4.0.0
	 */
	public function cron_deactivation(): void {
		$schedule = _get_cron_array();
		foreach ( $schedule as $timestamp => $cron ) {
			foreach ( $cron as $hook => $arg_wrapper ) {
				if ( preg_match( '/^wp_plugin_skeleton_schedule/', $hook ) ) {
					wp_unschedule_event( $timestamp, $hook );
					foreach ( $arg_wrapper as $args ) {
						wp_clear_scheduled_hook( $hook, $args['args'] );
					}
				}
			}
		}

	}

}
