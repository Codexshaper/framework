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
 * Module make command class to generate post_type
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class MakePostType extends Command {

	/**
	 * Name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var string The command name.
	 */
	public $name = 'cxf-make:post-type';

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
			\WP_CLI::error( 'You must provide post type name name and object option.e.g: `php wp cxf-make:post-type book`.' );
		}

		$post_type_config = cxf_config( 'post-type' );
		$app_config   = cxf_config( 'app' );
		$plugin_namespace = $app_config['plugin_namespaces'] ?? '';

		foreach ( $this->args as $arg ) {

			$title               = cxf_title( $arg );
			$class_name          = str_replace( ' ', '', $title );
			$post_type_namespace = $post_type_config['namespace'] ?? $plugin_namespace . 'PostTypes';
			$stub_name           = $post_type_config['stub_name'] ?? 'post-type';
			$post_type           = str_replace( ' ', '-', strtolower( $title ) );
			$post_type_dir       = $post_type_config['base_path'] ?? cxf_plugin_base_path() . 'src/PostTypes';

			if ( ! is_dir( $post_type_dir ) ) {
				wp_mkdir_p( $post_type_dir );
				\WP_CLI::success( "The post_type {$post_type}'s post_type directory has been created at $post_type_dir this location." );
			}

			if ( file_exists( $post_type_dir . "/{$class_name}.php" ) ) {
				\WP_CLI::warning( "The post_type {$post_type}'s post_type file has been created at {$post_type_dir}/{$class_name}.php this location." );
				return;
			}

			( new Stub(
				"{$stub_name}.stub",
				array(
					'NAMESPACE' => $post_type_namespace,
					'CLASS'     => $class_name,
					'POST_TYPE' => substr(sanitize_key($post_type), 0, 20),
				)
			) )->saveTo( $post_type_dir, "{$class_name}.php" );

			\WP_CLI::success( "The post_type {$post_type}'s post_type file has been created at {$post_type_dir}/{$class_name}.php this location." );

		}
	}
}
