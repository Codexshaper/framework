<?php
/**
 * Caller Trait file
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
 * Caller trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Caller {

	/**
	 * Caller
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return mixed The getter value.
	 */
	public function __call( $name, $arguments = array() ) {
		if ( ! method_exists( $this, $name ) ) {
			// Getter
			if ( preg_match( '/^get_(.+)/', $name, $matches ) ) {
				$property = $matches[1];
				return $this->{$property} ?? $arguments[0] ?? '';
			}

			// Setter
			if ( preg_match( '/^set_(.+)/', $name, $matches ) ) {
				$property          = $matches[1];
				$this->{$property} = $arguments[0] ?? $matches[1];
			}
		}
	}
}
