<?php
/**
 * Post Type Service Provider File
 *
 * @category   ServiceProvider
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Providers;

use CodexShaper\Framework\Foundation\PostType;
use CodexShaper\Framework\Foundation\ServiceProvider;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 *  Post Type Service Provider Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
final class PostTypeServiceProvider extends ServiceProvider {

	/**
	 * @var PostType[]
	 */
	private $post_types = array();

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		$post_types = array();

		$post_type_directory = csmf_plugin_base_path() . 'src/PostTypes/*';

		foreach ( glob( $post_type_directory ) as $path ) {
			if ( is_file( $path ) ) {
				$post_type = basename( $path, '.php' );

				if ( ! in_array( $post_type, $post_types, true ) ) {
					$post_types[] = $post_type;
				}
			}
		}

		foreach ( $post_types as $post_type_name ) {
			$words               = str_replace( '-', ' ', $post_type_name );
			$post_type_namespace = str_replace( ' ', '', ucwords( $words ) );
			$post_type_class     = sprintf( '%s%s', '\CodexShaper\Framework\PostTypes\\', $post_type_namespace );

			if ( $post_type_class::is_active() ) {
				$this->post_types[ $post_type_name ] = new $post_type_class();
			}
		}
	}

	/**
	 * Get post_types
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string|null $post_type_name The post_type name.
	 *
	 * @return PostType|PostType[]
	 */
	public function get_post_types( $post_type_name = null ) {
		if ( $post_type_name ) {
			if ( isset( $this->post_types[ $post_type_name ] ) ) {
				return $this->post_types[ $post_type_name ];
			}

			return null;
		}

		return $this->post_types;
	}
}
