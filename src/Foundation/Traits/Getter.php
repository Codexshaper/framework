<?php
/**
 * Getter Trait file
 *
 * @category   Core
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits;

/**
 * Getter trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Getter {

	/**
	 * Getter
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return mixed The getter value.
	 */
	public function __get( $name ) {
		$class_name = get_called_class();
		if ( property_exists( $class_name, $name ) ) {
			return $this->{$name};
		}

		return null;
	}
}
