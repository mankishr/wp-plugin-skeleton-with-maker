<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Game_Score entity class.
 *
 * A class that is used to establish a mapping between an object and table in the database.
 *
 * @since      4.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Repository
 */

namespace Wp_Plugin_Skeleton\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Wp_Plugin_Skeleton_Game_Score implements Wp_Plugin_Skeleton_Entity
{
    /*
     * @var int
     */
    protected $id;

    /*
     * @var string
     */
    protected $uuid;

    /*
     * @var string
     */
    protected $game_name;

    /*
     * @var int
     */
    protected $score;

    /**
     * Datetime when it is created.
     *
     * @var string|null|\DateTime $created_at
     */
    protected $created_at;

    /**
     * Wp_Plugin_Skeleton_Game_Score constructor.
     * @param int $score
     * @param string $game_name
     * @param int|null $id
     * @param string|null $uuid
     * @param \DateTime|null $created_at
     * @throws \Exception
     */
    public function __construct(int $score, string $game_name, int $id = null, string $uuid = null, \DateTime $created_at = null)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->game_name = $game_name;
        $this->score = $score;
        $this->created_at = $created_at;
        if( !$created_at ){
            $now = new \DateTime('now');
            $this->set_created_at($now);
        }
    }

    /**
     * @return int|null
     */
    public function get_id():? int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function set_id(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function get_uuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function set_uuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function get_score(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function set_score(int $score): void
    {
        $this->score = $score;
    }


    /**
     * @return string|null
     */
    public function get_game_name():? string
    {
        return $this->game_name;
    }

    /**
     * @param string $game_name
     */
    public function set_game_name(string $game_name): void
    {
        $this->game_name = stripslashes($game_name);
    }

    /**
     * Getter for the q_updated_at parameter.
     *
     * @return string|null
     */
    public function get_created_at(): string
    {
        return $this->created_at;
    }

    /**
     * Setter for the q_updated_at parameter.
     *
     * @param mixed $created_at Created at date.
     * @throws \Exception
     */
    public function set_created_at( mixed $created_at ): void {
        if ( $created_at instanceof \DateTime ) {
            $this->created_at = $created_at;
        } elseif ( \is_string( $created_at ) ) {
            $this->created_at = new \DateTime( $created_at );
        } elseif ( \is_int( $created_at ) ) {
            $this->created_at = new \DateTime( gmdate( DATE_ATOM, $created_at ) );
        }
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint(
            'id',
            new Assert\Positive()
        );

        $metadata->addPropertyConstraint(
            'score',
            new Assert\Positive()
        );

        $metadata->addPropertyConstraint(
            'game_name',
            new Assert\NotBlank()
        );

        $metadata->addPropertyConstraint(
            'created_at',
            new Assert\DateTime()
        );

    }
}