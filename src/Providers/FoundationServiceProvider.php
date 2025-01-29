<?php
/**
 *  Foundation Service Provider File
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

/**
 *  Foundation Service Provider Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class FoundationServiceProvider extends ServiceProvider {
	/**
	 * The provider class names.
	 *
	 * @var string[]
	 */
	public $providers = array(
		'plugins_loaded' => array(
			PostTypeServiceProvider::class,
			TaxonomyServiceProvider::class,
			MetaBoxServiceProvider::class,
			WidgetServiceProvider::class,
			ConsoleServiceProvider::class,
		),
	);

	/**
	 * The bindigs to register into the container.
	 *
	 * @var array
	 */
	public $bindings = array();

	/**
	 * The singletons to register into the container.
	 *
	 * @var array
	 */
	public $singletons = array();

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot() {
		// Booted code.
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		// Registered code.

		$this->providers = apply_filters( 'cxf_foundation_providers', $this->providers );
	}
}
