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

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Wp_Plugin_Skeleton\Factory\Wp_Plugin_Skeleton_Game_Score_Factory;
use Wp_Plugin_Skeleton\Repository\Wp_Plugin_Skeleton_Game_Score_Repository;
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
     * @var Wp_Plugin_Skeleton_Game_Score_Repository
     */
    private $scores_table_repository;

    /**
     * @var Wp_Plugin_Skeleton_Game_Score_Factory 
     */
    private $game_score_factory;

    /**
     * @var ValidatorInterface 
     */
    private $validator;

    /**
     * @param Wp_Plugin_Skeleton_Game_Score_Repository $scores_table_repository
     * @param Wp_Plugin_Skeleton_Game_Score_Factory $game_score_factory
     * @param ValidatorInterface $validator
     */
    public function __construct(Wp_Plugin_Skeleton_Game_Score_Repository $scores_table_repository, Wp_Plugin_Skeleton_Game_Score_Factory $game_score_factory, ValidatorInterface $validator )
    {
        $this->scores_table_repository = $scores_table_repository;
        $this->game_score_factory = $game_score_factory;
        $this->validator = $validator;
    }

    /**
     * @throws \JsonException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     *
     * @since      5.0.0
     */
    public function import_game_scores(): void
    {
        $json = file_get_contents(WP_PLUGIN_SKELETON_PATH.'src/public/game_scores_example.json');
        $scores = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        foreach ($scores as $score){
            $game_score = $this->game_score_factory->create($score);
            $errors = $this->validator->validate($game_score);

            if (count($errors) === 0) {
                $results_data_for_import = $this->entity_serializer('game-score')->normalize($game_score, null, ['groups' => 'all']);
                $this->scores_table_repository->insert($results_data_for_import);
            }
            // @todo uncomment else when you decide what to do in case of an error
            //else{
                /*
                 * Uses a __toString method on the $errors variable which is a
                 * ConstraintViolationList object. This gives us a nice string
                 * for debugging.
                 */
             //   error_log((string)$errors);
            //}
        }
    }
}