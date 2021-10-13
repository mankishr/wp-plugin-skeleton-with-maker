<?php
/**
 * Wp_Plugin_Skeleton_Import_Scores_Command class.
 *
 * Command class for game score import execution during cron job.
 *
 * @since      5.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Command
 */

namespace Wp_Plugin_Skeleton\Command;

use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;

class Wp_Plugin_Skeleton_Import_Scores_Command implements Wp_Plugin_Skeleton_Command
{

    /**
     * Executes command.
     */
    public function execute(): void
    {
        Wp_Plugin_Skeleton_Service_Container::get_instance()->wp_plugin_skeleton_scores_service()->import_game_scores();
    }
}