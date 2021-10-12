<?php
/**
 * This is the factory interface.
 *
 * Factory interface class that holds create method.
 *
 * @since      4.0.0
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Factory
 */

namespace Wp_Plugin_Skeleton\Factory;

/**
 * Interface Wp_Plugin_Skeleton_Factory_Interface.
 *
 * Factory interface class that holds create method.
 *
 * @package    Wp_Plugin_Skeleton
 * @subpackage Wp_Plugin_Skeleton\Factory
 * @author     Anka Bajurin Stiskalov
 */
interface Wp_Plugin_Skeleton_Entity_Factory_Interface {

	/**
	 * This method should handle validation for entity values and return entity object or throw an error.
	 *
	 * @param array $data Array with object data.
	 */
	public function create( array $data);
}
