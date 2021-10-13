<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Command interface
 *
 * Interface for command classes.
 *
 * @since      5.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Command
 */

namespace Wp_Plugin_Skeleton\Command;

/**
 * Interface Wp_Plugin_Skeleton_Command
 *
 * Interface for classes that execute process for cron job.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Command
 * @author     Anka Bajurin Stiskalov
 */
interface Wp_Plugin_Skeleton_Command {

	/**
	 * Executes command.
	 */
	public function execute(): void;
}
