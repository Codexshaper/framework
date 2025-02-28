<?php
/**
 * Custom Option Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder;

/**
 * Option class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Option {

	/**
	 * Admin Option Create
	 *
	 * Create admin option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 * @return void
	 */
	public static function create( $identifier, $options = array() ) {
		Builder::createOptions( $identifier, $options );
	}

	/**
	 * Admin Option Create
	 *
	 * Create admin option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function admin( $identifier, $options = array() ) {
		Builder::createOptions( $identifier, $options );
	}

	/**
	 * Customize option Create
	 *
	 * Create customize option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function customize( $identifier, $options = array() ) {
		Builder::createCustomizeOptions( $identifier, $options );
	}

	/**
	 * Section Create
	 *
	 * Create section option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function section( $identifier, $options = array() ) {
		Builder::createSection( $identifier, $options );
	}

	/**
	 * Metabox Create
	 *
	 * Create metabox option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function metabox( $identifier, $options = array() ) {
		Builder::createMetabox( $identifier, $options );
	}

	/**
	 * Taxonomy Create
	 *
	 * Create taxonomy option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function taxonomy( $identifier, $options = array() ) {
		Builder::createTaxonomyOptions( $identifier, $options );
	}

	/**
	 * Widget Create
	 *
	 * Create widget option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function widget( $identifier, $options = array() ) {
		Builder::createWidget( $identifier, $options );
	}

	/**
	 * Menu Create
	 *
	 * Create menu option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function menu( $identifier, $options = array() ) {
		Builder::createMenuOptions( $identifier, $options );
	}

	/**
	 * Profile Create
	 *
	 * Create profile option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function profile( $identifier, $options = array() ) {
		Builder::createProfileOptions( $identifier, $options );
	}

	/**
	 * Comment Create
	 *
	 * Create comment option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function comment( $identifier, $options = array() ) {
		Builder::createCommentMetabox( $identifier, $options );
	}

	/**
	 * Shortcode Create
	 *
	 * Create shortcoder option.
	 *
	 * @since 1.0.0
	 * @static
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function shortcode( $identifier, $options = array() ) {
		Builder::createShortcoder( $identifier, $options );
	}
}
