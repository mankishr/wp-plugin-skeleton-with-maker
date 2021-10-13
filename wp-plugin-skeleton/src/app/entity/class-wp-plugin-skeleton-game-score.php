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
     * Datetime converted to string.
     *
     * @var string $created_at
     */
    protected $created_at;

    /**
     * Final_Plugin_Game_Score constructor.
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
        if (!$created_at) {
            $now = new \DateTime('now');
            $this->setCreatedAt($now);
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getGameName(): string
    {
        return $this->game_name;
    }

    /**
     * @param string $game_name
     */
    public function setGameName(string $game_name): void
    {
        $this->game_name = $game_name;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * Getter for the created_at parameter.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Setter for the created_at parameter.
     *
     * @param \DateTime $created_at Created at datetime.
     */
    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at->format('Y-m-d H:i:s');
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint(
            'id',
            new Assert\NotBlank(['allowNull' => true])
        );

        $metadata->addPropertyConstraint(
            'id',
            new Assert\Positive()
        );

        $metadata->addPropertyConstraint(
            'uuid',
            new Assert\NotBlank()
        );

        $metadata->addPropertyConstraint(
            'uuid',
            new Assert\Uuid()
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