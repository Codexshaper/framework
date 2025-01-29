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
 * Module make command class to generate metabox
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class MakeMetaBox extends Command {

	/**
	 * Name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var string The command name.
	 */
	public $name = 'cxf-make:metabox';

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
			\WP_CLI::error( 'You must provide post type name name and object option.e.g: `php wp cxf-make:metabox OptionPanelMetaBox`.' );
		}

		foreach ( $this->args as $arg ) {

			$title             = cxf_title( $arg );
			$class_name        = str_replace( ' ', '', $title );
			$metabox_namespace = 'CodexShaper\Framework\MetaBoxes';
			$stub_name         = 'metabox';
			$metabox_id        = str_replace( ' ', '_', strtolower( $title ) );
			$metabox_dir       = cxf_plugin_base_path() . 'src/MetaBoxes';
			$metabox_prefix    = 'cxf';

			if ( ! is_dir( $metabox_dir ) ) {
				wp_mkdir_p( $metabox_dir );
				\WP_CLI::success( "The metabox {$arg}'s metabox directory has been created at $metabox_dir this location." );
			}

			( new Stub(
				"{$stub_name}.stub",
				array(
					'NAMESPACE' => $metabox_namespace,
					'CLASS'     => $class_name,
					'ID'        => "{$metabox_prefix}_{$metabox_id}",
					'TITLE'     => $title,
					'SCREENS'   => $this->assoc_args['screen'] ?? '',
				)
			) )->saveTo( $metabox_dir, "{$class_name}.php" );

			\WP_CLI::success( "The metabox {$arg}'s metabox file has been created at {$metabox_dir}/{$class_name}.php this location." );

		}
	}
}
