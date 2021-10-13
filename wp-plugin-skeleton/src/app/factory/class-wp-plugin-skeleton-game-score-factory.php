<?php


namespace Wp_Plugin_Skeleton\Factory;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Wp_Plugin_Skeleton\Traits\Wp_Plugin_Skeleton_Survey_Serializer;
use Wp_Plugin_Skeleton\Entity\Wp_Plugin_Skeleton_Game_Score;

class Wp_Plugin_Skeleton_Game_Score_Factory implements Wp_Plugin_Skeleton_Entity_Factory_Interface
{
    use Wp_Plugin_Skeleton_Survey_Serializer;

    /**
     * Crete new Wp_Plugin_Skeleton_Game_Score instance.
     *
     * @param array $data
     * @return Wp_Plugin_Skeleton_Game_Score
     * @throws ExceptionInterface
     */
    public function create( array $data ): Wp_Plugin_Skeleton_Game_Score
    {
        return $this->entity_serializer('game-score')->denormalize(
            $data,
            Wp_Plugin_Skeleton_Game_Score::class,
            null,
            ['groups' => ['all']]
        );

    }
}