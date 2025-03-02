<?php
/**
 * Config file
 *
 * @category   Support
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Config;

// exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Config class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Config {

	/**
	 * The Configs
	 *
	 * @var array The Configs.
	 */
	protected $configs = array();

	/**
	 * The App
	 *
	 * @var object The App.
	 */
	protected $app;

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
	public function __construct($app) {
		// Do your settings here
		$this->app = $app;
	}

	/**
	 * Get the Config
	 *
	 * @param string $path The path of the config.
	 * @return WP_Config The Config instance.
	 */
	public function get( $path ) {
		$path  = str_replace( array( '.', '|' ), ' ', $path );
		$parts = explode( ' ', $path );
		$config_name = $parts[0] ?? '';
		$configs = $this->configs[ $config_name ] ?? array();

		if ( empty($configs) && count( $parts ) > 0 ) {
			
			$config_path = CSMF_PLUGIN_CONFIG_PATH . $config_name . '.php';

			if ( ! file_exists( $config_path ) ) {
				$config_path = trailingslashit(untrailingslashit(dirname(__DIR__))) . '../config/' . $config_name . '.php';
			}

			if (! file_exists( $config_path ) ) {
				return $configs;
			}

			$configs = include $config_path;
		}

		unset( $parts[0] );

		foreach ( $parts as $part ) {
			$configs = $configs[ $part ] ?? array();
		}

		$this->configs[ $config_name ] = $configs;

		return $configs;
	}

	/**
	 * Set the Config
	 *
	 * @param string $name The name of the config.
	 * @param mixed  $value The value of the config.
	 * 
	 * @since 1.0.0
	 * 
	 * @return Config The Config instance.
	 */
	public function set( $name, $value ) {
		$this->configs[ $name ] = $value;

		return $this;
	}
}
