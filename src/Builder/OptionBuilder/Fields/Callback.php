<?php
/**
 * Callback Field Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder\OptionBuilder\Fields;

use CodexShaper\Framework\Foundation\Builder\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Callback Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Callback extends Field {

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		// Check if the field has a valid function.
		if ( isset( $this->field['function'] ) && is_callable( $this->field['function'] ) ) {
			// Check if the field has additional arguments to pass to the callback function.
			$args = ( isset( $this->field['args'] ) ) ? $this->field['args'] : null;

			// Call the callback function with any additional arguments.
			call_user_func( $this->field['function'], $args );
		}
	}
}
