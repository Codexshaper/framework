<?php
/**
 * Post file
 *
 * @category   ORM
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Models\Post;

use CodexShaper\Framework\Foundation\Model;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/cmf
 * @since      1.0.0
 */
class Post extends Model {

	/**
	 * Get public post types
	 *
	 * @param array $args   Arguments to retrieve post types.
	 * @param array $defaults   Default post types.
	 *
	 * @return array $post_types    Post types.
	 */
	public static function get_public_types( $args = array(), $defaults = array() ) {
		$post_type_args = array(
			// Default is the value $public.
			'show_in_nav_menus' => true,
		);

		// Keep for backwards compatibility.
		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['name'] = $args['post_type'];
			unset( $args['post_type'] );
		}

		$post_type_args = wp_parse_args( $post_type_args, $args );

		$_post_types = get_post_types( $post_type_args, 'objects' );

		$post_types = $defaults;

		if ( ! is_array( $post_types ) ) {
			$post_type = array();
		}

		foreach ( $_post_types as $post_type => $object ) {
			$post_types[ $post_type ] = $object->label;
		}

		return $post_types;
	}

	/**
	 * Get public post types
	 *
	 * @param array $args   Arguments to retrieve post types.
	 * @param array $defaults   Default post types.
	 *
	 * @return array $post_types    Post types.
	 */
	public static function types( $args = array(), $defaults = array() ) {

		return static::get_public_types( $args, $defaults );
	}
}
