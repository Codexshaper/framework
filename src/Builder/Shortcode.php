<?php
/**
 * Shortcode Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shortcode option class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Shortcode {

	/**
	 * Shortcode Create
	 *
	 * Create shortcoder option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create( $identifier, $options = array() ) {
		Builder::createShortcoder( $identifier, $options );
	}
}
