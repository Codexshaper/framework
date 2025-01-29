<?php
/**
 *  Console Service Provider File
 *
 * @category   ServiceProvider
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Providers;

use CodexShaper\Framework\Commands\MakeMetaBox;
use CodexShaper\Framework\Commands\MakePostType;
use CodexShaper\Framework\Commands\MakeTaxonomy;
use CodexShaper\Framework\Commands\MakeWidget;
use CodexShaper\Framework\Commands\ModuleMake;
use CodexShaper\Framework\Foundation\ServiceProvider;
use WP_CLI;

/**
 * Console Service Provider Class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class ConsoleServiceProvider extends ServiceProvider {
	/**
	 * The provider class names.
	 *
	 * @var string[]
	 */
	public $providers = array();

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
	 * Commands
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @var array List of commands.
	 */
	protected $commands = array(
		ModuleMake::class,
		MakePostType::class,
		MakeTaxonomy::class,
		MakeWidget::class,
		MakeMetaBox::class,
	);

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot() {
		// Booted code
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->providers = apply_filters( 'cxf_console_providers', $this->providers );
		$this->commands  = apply_filters( 'cxf_console_commands', $this->commands );

		// Registere code
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			$this->register_commands();
		}
	}

	/**
	 * Register commands
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register_commands() {
		foreach ( $this->commands as $command ) {

			if ( class_exists( $command ) ) {
				$new_command = new $command();
				WP_CLI::add_command( $new_command->name, $new_command );
			}
		}
	}
}
