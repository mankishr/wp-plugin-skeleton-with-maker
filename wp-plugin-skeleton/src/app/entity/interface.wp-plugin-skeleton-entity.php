<?php
/**
 * The file that defines the Wp_Plugin_Skeleton_Entity interface.
 *
 * An interface for a class that is usually used to establish a mapping between an object and to a table in the database.
 *
 * @since      4.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Repository
 */

namespace Wp_Plugin_Skeleton\Entity;


interface Wp_Plugin_Skeleton_Entity
{
    /**
     * @return int|null
     */
    public function getId():? int;

    /**
     * @param int $id
     */
    public function setId(int $id): void;
}