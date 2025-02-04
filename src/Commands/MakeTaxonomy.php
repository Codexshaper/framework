<?php
/**
 * Module make command file
 *
 * @category   Command
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Commands;

use CodexShaper\Framework\Foundation\Console\Command;
use CodexShaper\Framework\Support\Stub;

if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if access directly.
}

/**
 * Module make command class to generate taxonomy
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class MakeTaxonomy extends Command {

	/**
	 * Name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var string The command name.
	 */
	public $name = 'cxf-make:taxonomy';

	/**
	 * Handle Command
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function handle() {

		if ( empty( $this->args ) ) {
			\WP_CLI::error( 'You must provide taxonomy name and object option.' );
		}

		$taxonomy_config = cxf_config( 'taxonomy' );
		$app_config   = cxf_config( 'app' );
		$plugin_namespace = $app_config['plugin_namespaces'] ?? '';

		foreach ( $this->args as $arg ) {

			// if (! key_exists( 'object', $this->assoc_args )) {
			// \WP_CLI::error( "object option required. e.g: --object=post" );
			// }

			$title              = cxf_title( $arg );
			$class_name         = str_replace( ' ', '', $title );
			$taxonomy_name      = strtolower( str_replace( ' ', '-', $title ) );
			$taxonomy_namespace = $taxonomy_config['namespace'] ?? $plugin_namespace . 'Taxonomies';
			$stub_name          = $taxonomy_config['stub_name'] ?? 'taxonomy';
			$taxonomy           = str_replace( ' ', '', strtolower( $title ) );
			$taxonomy_dir       = $taxonomy_config['base_path'] ?? cxf_plugin_base_path() . 'src/Taxonomies';

			if ( ! is_dir( $taxonomy_dir ) ) {
				wp_mkdir_p( $taxonomy_dir );
				\WP_CLI::success( "The taxonomy {$taxonomy}'s taxonomy directory has been created at $taxonomy_dir this location." );
			}

			if ( file_exists( $taxonomy_dir . "/{$class_name}.php" ) ) {
				\WP_CLI::warning( "The taxonomy {$taxonomy}'s taxonomy file has been created at {$taxonomy_dir}/{$class_name}.php this location." );
				return;
			}

			( new Stub(
				"{$stub_name}.stub",
				array(
					'NAMESPACE'     => $taxonomy_namespace,
					'CLASS'         => $class_name,
					'TAXONOMY_NAME' => substr(sanitize_key($taxonomy_name), 0, 32),
					'OBJECT_TYPE'   => $this->assoc_args['object'] ?? 'post',
				)
			) )->saveTo( $taxonomy_dir, "{$class_name}.php" );

			\WP_CLI::success( "The taxonomy {$taxonomy}'s taxonomy file has been created at {$taxonomy_dir}/{$class_name}.php this location." );

		}
	}
}
