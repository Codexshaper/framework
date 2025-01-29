<?php
/**
 * Widget Service Provider File
 *
 * @category   Service Provider
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Providers;

use CodexShaper\Framework\Foundation\ServiceProvider;
use CodexShaper\Framework\Foundation\Widget;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Widget Service Provider Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class WidgetServiceProvider extends ServiceProvider {

	/**
	 * @var Widget[]
	 */
	private $widgets = array();

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
		$widgets = array();

		$widget_directory = cxf_plugin_base_path() . 'widgets/wordpress/modules/*/';
		foreach ( glob( $widget_directory ) as $path ) {
			if ( is_dir( $path ) ) {
				$parts  = explode( '/', untrailingslashit( $path ) );
				$widget = end( $parts );

				if ( ! in_array( $widget, $widgets, true ) ) {
					$widgets[] = $widget;
				}
			}
		}

		foreach ( $widgets as $widget_name ) {
			$words            = str_replace( '-', ' ', $widget_name );
			$widget_namespace = str_replace( ' ', '', ucwords( $words ) );
			$widget_class     = '\CodexShaper\Framework\Widgets\Wordpress\Modules\\' . $widget_namespace . '\Module';

			if ( $widget_class::is_active() ) {
				$this->widgets[ $widget_name ] = $widget_class::instance();
			}
		}
	}

	/**
	 * Get widgets
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string|null $widget_name The widget name.
	 *
	 * @return Widget|Widget[]
	 */
	public function get_widgets( $widget_name = null ) {
		if ( $widget_name ) {
			if ( isset( $this->widgets[ $widget_name ] ) ) {
				return $this->widgets[ $widget_name ];
			}

			return null;
		}

		return $this->widgets;
	}
}
