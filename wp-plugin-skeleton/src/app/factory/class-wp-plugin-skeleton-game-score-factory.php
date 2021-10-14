<?php
/**
 * This is the Wp_Plugin_Skeleton_Game_Score_Factory class.
 *
 * Factory Wp_Plugin_Skeleton_Game_Score_Factory creates Wp_Plugin_Skeleton_Game_Score entity.
 *
 * @since      4.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Factory
 */

namespace Wp_Plugin_Skeleton\Factory;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Wp_Plugin_Skeleton\Traits\Wp_Plugin_Skeleton_Survey_Serializer;
use Wp_Plugin_Skeleton\Entity\Wp_Plugin_Skeleton_Game_Score;

class Wp_Plugin_Skeleton_Game_Score_Factory implements Wp_Plugin_Skeleton_Entity_Factory_Interface
{
    use Wp_Plugin_Skeleton_Survey_Serializer;

    /**
     * Crete new entity.
     *
     * @param array $data - normalized entity
     * @return array|object
     * @throws ExceptionInterface
     * @throws \Exception
     */
    public function create( array $data ): object|array
    {
        $data['created_at'] = isset($data['created_at']) ? new \DateTime($data['created_at']) : new \DateTime('now');

        return $this->entity_serializer('game-score')->denormalize(
            $data,
            Wp_Plugin_Skeleton_Game_Score::class,
            null,
            ['groups' => ['all']]
        );
    }
}