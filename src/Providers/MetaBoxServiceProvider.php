<?php
/**
 * MetaBox Service Provider File
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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  MetaBox manager class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class MetaBoxServiceProvider extends ServiceProvider {

	/**
	 * @var MetaBox[]
	 */
	private $meta_boxes = array();

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
		$meta_boxes = array();

		$meta_box_directory = cxf_plugin_base_path() . 'src/MetaBoxes/*';

		foreach ( glob( $meta_box_directory ) as $path ) {
			if ( is_file( $path ) ) {
				$meta_box = basename( $path, '.php' );

				if ( ! in_array( $meta_box, $meta_boxes, true ) ) {
					$meta_boxes[] = $meta_box;
				}
			}
		}

		foreach ( $meta_boxes as $meta_box_name ) {
			$words              = str_replace( '-', ' ', $meta_box_name );
			$meta_box_namespace = str_replace( ' ', '', ucwords( $words ) );
			$meta_box_class     = sprintf( '%s%s', '\CodexShaper\Framework\MetaBoxes\\', $meta_box_namespace );

			if ( $meta_box_class::is_active() ) {
				$this->meta_boxes[ $meta_box_name ] = new $meta_box_class();
			}
		}
	}

	/**
	 * Get meta_boxes
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string|null $meta_box The meta_box name.
	 *
	 * @return MetaBox|MetaBox[]
	 */
	public function get_meta_boxes( $meta_box = null ) {
		if ( $meta_box ) {
			if ( isset( $this->meta_boxes[ $meta_box ] ) ) {
				return $this->meta_boxes[ $meta_box ];
			}

			return null;
		}

		return $this->meta_boxes;
	}
}
