<?php

namespace Wp_Plugin_Skeleton\Traits;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\XmlFileLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
 * The constraint class for unique entity constraint.
 *
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton/Traits
 * @author     Anka Bajurin Stiskalov
 */
trait Wp_Plugin_Skeleton_Entity_Serializer
{
    public function entity_serializer(string $class_alias): Serializer{
        $classMetadataFactory = new ClassMetadataFactory(new XmlFileLoader(WP_PLUGIN_SKELETON_PATH.'src/app/serializer_mapping/class-wp-plugin-skeleton-'.$class_alias.'-definition.xml'));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        return new Serializer([$normalizer]);
    }
}