<?php
/**
 * Service Provider Base file
 *
 * @category   ServiceProvider
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Service Provider Base Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://github.com/CodexShaper-Devs/csmf
 * @since      1.0.0
 */
abstract class ServiceProvider {

	/**
	 * The application instance.
	 *
	 * @var \CodexShaper\Framework\Contracts\Foundation\Application
	 */
	protected $app;

	/**
	 * The provider class names.
	 *
	 * @var array
	 */
	public $providers = array(
		'plugins_loaded' => array(
			// Write providers that you want to load after all plugins loaded.
		),
		// Write immediate providers here.
	);

	/**
	 * An array of the service provider instances.
	 *
	 * @var array
	 */
	public $instances = array();

	/**
	 * All of the bindings.
	 *
	 * @var array
	 */
	public $bindings = array();

	/**
	 * All of the singletons.
	 *
	 * @var array
	 */
	public $singletons = array();

	/**
	 * Create a new service provider instance.
	 *
	 * @param  \CodexShaper\Framework\Contracts\Foundation\Application $app
	 * @return void
	 */
	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * Boot any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// Booted code here.
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		// Register code here.
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		$provides = array();

		foreach ( $this->providers as $provider ) {
			$instance = $this->app->resolve_provider( $provider );

			$provides = array_merge( $provides, $instance->provides() );
		}

		return $provides;
	}
}
