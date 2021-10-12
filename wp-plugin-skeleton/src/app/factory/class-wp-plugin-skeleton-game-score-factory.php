<?php


namespace Wp_Plugin_Skeleton\Factory;

use Wp_Plugin_Skeleton\Traits\Wp_Plugin_Skeleton_Survey_Serializer;
use Wp_Plugin_Skeleton\Entity\Wp_Plugin_Skeleton_Game_Score;

class Wp_Plugin_Skeleton_Game_Score_Factory implements Wp_Plugin_Skeleton_Entity_Factory_Interface
{
    use Wp_Plugin_Skeleton_Survey_Serializer;

    /** Crete new survey
     * @param array $data - normalized survey
     * @return array|object
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function create( array $data ) {

        return $this->entity_serializer('results')->denormalize(
            $data,
            Wp_Plugin_Skeleton_Game_Score::class,
            null,
            ['groups' => ['all']]
        );

    }
}