<?php
/**
 * Option Builder
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
 * Option COB class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class COB {

	/**
	 * Instance
	 *
	 * @var \CodexShaper\Framework\Builder\COB
	 * @static
	 * @access private
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 * @return \CodexShaper\Framework\Builder\COB An instance of the class.
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Admin Option Create
	 *
	 * Create admin option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_options( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Option::create( $identifier, $options );
		}
	}

	/**
	 * Customize option Create
	 *
	 * Create customize option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_customize_options( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Option::customize( $identifier, $options );
		}
	}

	/**
	 * Section Create
	 *
	 * Create section option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_section( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Section::create( $identifier, $options );
		}
	}

	/**
	 * Metabox Create
	 *
	 * Create metabox option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_metabox( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Metabox::create( $identifier, $options );
		}
	}

	/**
	 * Taxonomy Create
	 *
	 * Create taxonomy option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_taxonomy_options( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Taxonomy::create( $identifier, $options );
		}
	}

	/**
	 * Widget Create
	 *
	 * Create widget option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_widget( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Widget::create( $identifier, $options );
		}
	}

	/**
	 * Menu Create
	 *
	 * Create menu option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_nav_menu_options( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Menu::create( $identifier, $options );
		}
	}

	/**
	 * Profile Create
	 *
	 * Create profile option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_profile_options( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Profile::create( $identifier, $options );
		}
	}

	/**
	 * Comment Create
	 *
	 * Create comment option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $identifier Option identifier.
	 * @param array  $options Option arguments.
	 *
	 * @return void
	 */
	public static function create_comment_metabox( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Comment::create( $identifier, $options );
		}
	}

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
	public static function create_shortcoder( $identifier, $options = array() ) {
		if ( class_exists( '\CSMF' ) ) {
			Shortcode::create( $identifier, $options );
		}
	}
}
