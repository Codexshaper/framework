<?php
/**
 * PostType Builder
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
 * PostType option class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class CustomPostType {

	/**
	 * PostType Create
	 *
	 * Create PostType option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Post Type identifier.
	 * @param array  $args Post Type arguments.
	 *
	 * @return void
	 */
	public static function create( $identifier, $args = array() ) {
		Builder::createPostType( $identifier, $args );
	}
}
