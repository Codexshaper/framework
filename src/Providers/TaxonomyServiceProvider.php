<?php
/**
 * Taxonomy Service Provider File
 *
 * @category   ServiceProvider
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Providers;

use CodexShaper\Framework\Foundation\ServiceProvider;
use CodexShaper\Framework\Foundation\Taxonomy;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Wideget Service Provider Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class TaxonomyServiceProvider extends ServiceProvider {

	/**
	 * @var Taxonomy[]
	 */
	private $taxonomies = array();

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
		$taxonomies = array();

		$taxonomy_directory = cmf_plugin_base_path() . 'src/Taxonomies/*';

		foreach ( glob( $taxonomy_directory ) as $path ) {
			if ( is_file( $path ) ) {
				$taxonomy = basename( $path, '.php' );

				if ( ! in_array( $taxonomy, $taxonomies, true ) ) {
					$taxonomies[] = $taxonomy;
				}
			}
		}

		foreach ( $taxonomies as $taxonomy_name ) {
			$words              = str_replace( '-', ' ', $taxonomy_name );
			$taxonomy_namespace = str_replace( ' ', '', ucwords( $words ) );
			$taxonomy_class     = sprintf( '%s%s', '\CodexShaper\Framework\Taxonomies\\', $taxonomy_namespace );

			if ( $taxonomy_class::is_active() ) {
				$this->taxonomies[ $taxonomy_name ] = new $taxonomy_class();
			}
		}
	}

	/**
	 * Get taxonomies
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string|null $taxonomy The taxonomy name.
	 *
	 * @return Taxonomy|Taxonomy[]
	 */
	public function get_taxonomies( $taxonomy = null ) {
		if ( $taxonomy ) {
			if ( isset( $this->taxonomies[ $taxonomy ] ) ) {
				return $this->taxonomies[ $taxonomy ];
			}

			return null;
		}

		return $this->taxonomies;
	}
}
