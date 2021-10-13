<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Scores_Service class
 *
 * Service class that handles scores import.
 *
 * @since      5.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Service
 */

namespace Wp_Plugin_Skeleton\Service;

use Wp_Plugin_Skeleton\Entity\Wp_Plugin_Skeleton_Game_Score;
use Wp_Plugin_Skeleton\Infrastructure\Wp_Plugin_Skeleton_Service_Container;
use Wp_Plugin_Skeleton\Repository\Wp_Plugin_Skeleton_Game_Score_Repository_Table;
use Wp_Plugin_Skeleton\Traits\Wp_Plugin_Skeleton_Survey_Serializer;

/**
 * Class Wp_Plugin_Skeleton_Cron_Service
 *
 * Service class that handles scores import.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Service
 * @author     Anka Bajurin Stiskalov
 */
class Wp_Plugin_Skeleton_Game_Scores_Service
{
    use Wp_Plugin_Skeleton_Survey_Serializer;

    /**
     * @var Wp_Plugin_Skeleton_Game_Score_Repository_Table
     *
     * @since      5.0.0
     */
    private $scores_table_repository;

    public function __construct( Wp_Plugin_Skeleton_Game_Score_Repository_Table $scores_table_repository )
    {
        $this->scores_table_repository = $scores_table_repository;
    }

    /**
     * @throws \JsonException
     *
     * @since      5.0.0
     */
    public function import_scores_json_feed(): void
    {
        $json = file_get_contents(WP_PLUGIN_SKELETON_PATH.'src/public/game_scores_example.json');
        $scores = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        foreach ($scores as $score){

            /** @var Wp_Plugin_Skeleton_Game_Score $game_score */
            $game_score = Wp_Plugin_Skeleton_Service_Container::get_instance()->q_surveyjs_results_factory()->create_survey_results($score);

            $errors = Wp_Plugin_Skeleton_Service_Container::get_instance()->q_surveyjs_validator()->validate($game_score);

            if (count($errors) > 0) {
                /*
                 * Uses a __toString method on the $errors variable which is a
                 * ConstraintViolationList object. This gives us a nice string
                 * for debugging.
                 */

                wp_send_json(['status' => 'error', 'message' => (string)$errors]);
                wp_die();
            }

            try{
                $results_data_for_import = $this->entity_serializer('results')->normalize($survey_results, null, ['groups' => 'all']);
                if ( $results_id = $this->scores_table_repository->insert($results_data_for_import)){
                    $survey_results->setId($results_id);

                }else{
                    wp_send_json( array('status' => 'error','message' => 'Results are not saved to database. Error unknown. ' ) );
                    wp_die();
                }
            }catch (\Exception $e) {
                wp_send_json( array('status' => 'error','message' => $e->getMessage() ) );
                wp_die();
            } catch (ExceptionInterface $e) {
                wp_send_json( array('status' => 'error','message' => $e->getMessage() ) );
                wp_die();
            }
        }
    }
}