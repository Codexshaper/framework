<?php
/**
 * Single Trait file
 *
 * @category   DesignPatterns
 * @version    1.0.0
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
namespace CodexShaper\Framework\Foundation\Traits;

/**
 * Singleton trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Singleton {

	/**
	 * Store all instances and keep remember.
	 *
	 * @var \CmfTheme\Inc\Traits\Singleton The single instance of the called class.
	 */
	private static $instances = array();

	/**
	 * Get which class is called when a class have parent or sub classes
	 *
	 * @return object Singleton instance of the class.
	 */
	final public static function instance( ...$args ) {

		// Gets the name of the class the static method is called in. Each called class tread as unique identifier of this class.
		$called_class_name = get_called_class();

		// Check the instance already exists. If not create new instance.
		if ( ! isset( static::$instances[ $called_class_name ] ) ) {
			// Create new instance and store in the instances.
			static::$instances[ $called_class_name ] = new $called_class_name( ...$args );

			// Use the `cmf_theme_singleton_init_{$instance}` hook to execute code for the dependent class or items.
			do_action( sprintf( 'cmf_theme_singleton_init_%s', $called_class_name ) ); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

		}

		return static::$instances[ $called_class_name ];
	}
}
