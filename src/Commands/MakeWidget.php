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
 * Module make command class to generate module
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class MakeWidget extends Command {

	/**
	 * Name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var string The command name.
	 */
	public $name = 'cxf-make:widget';

	protected $description = 'Create a new WordPress widget.';

	/**
	 * Handle Command
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function handle() {

		$module_config = cxf_config( 'module.widget.wordpress' );
		$app_config   = cxf_config( 'app' );
		$plugin_namespace = $app_config['plugin_namespaces'] ?? '';

		foreach ( $this->args as $arg ) {

			$title            		= cxf_title( $arg );
			$class_name       		= str_replace( ' ', '_', $title );
			$module_name      		= str_replace( ' ', '', $title );
			$base_path	 			= trailingslashit(untrailingslashit($module_config['base_path'] ?? cxf_plugin_base_path() . "widgets/wordpress"));
			$base_namespace	 		= $module_config['namespace'] ?? $plugin_namespace . 'Widgets\\Wordpress\\Modules';
			$module_namespace 		= "{$base_namespace}\\{$module_name}";
			$widget_namespace 		= "{$module_namespace}\\Widgets";
			$module_stub_name 		= $module_config['module_stub_name'] ?? 'wp-module';
			$widget_stub_name 		= $module_config['widget_stub_name'] ?? 'wp-widget';
			$view_stub_name     	= $module_config['view_stub_name'] ?? 'wp-view';
			$view_file_name     	= $module_config['view_file_name'] ?? 'content';
			$view_extension    		= $module_config['view_extension'] ?? 'view.php';
			$text_domain      		= $app_config['plugin_text_domain'] ?? 'codexshaper-framework';
			$module_prefix 			= $module_config['module_prefix'] ?? '';
			$widget_prefix 			= $module_config['widget_prefix'] ?? '';
			$module             	= str_replace( ' ', '-', strtolower( $title ) );
			$module_dir         	= $base_path . "modules/{$module}";
			$module_view_dir    	= $base_path . "views/{$module}";
			$module_widgets_dir 	= $base_path . "modules/{$module}/widgets";
			$widgets_css_dir    	= $base_path . 'assets/css';

			if ( ! is_dir( $module_widgets_dir ) ) {
				wp_mkdir_p( $module_widgets_dir );
				\WP_CLI::success( "The module {$module}'s module directory has been created at $module_dir this location." );
				\WP_CLI::success( "The module {$module}'s widgets directory has been created at $module_widgets_dir this location." );
			}

			if ( ! is_dir( $module_view_dir ) ) {
				wp_mkdir_p( $module_view_dir );
				\WP_CLI::success( "The module {$module}'s module directory has been created at $module_view_dir this location." );
			}

			if ( key_exists( 'skip-css', $this->assoc_args ) || key_exists( 'skip:css', $this->assoc_args ) ) {
				$module_stub_name .= '-skip-css';
				$widget_stub_name .= '-skip-css';
			}

			if ( ! file_exists( $module_dir . '/module.php' ) ) {
				( new Stub(
					"{$module_stub_name}.stub",
					array(
						'NAMESPACE'    => $module_namespace,
						'CLASS'        => 'Module',
						'WIDGET_CLASS' => $class_name,
						'MODULE_NAME'  => $module_prefix . $module,
						'WIDGET_NAME'  => $widget_prefix . $module,
						'TEXT_DOMAIN'  => $text_domain,
					)
				) )->saveTo( $module_dir, 'module.php' );
	
				\WP_CLI::success( "The module {$module}'s module file has been created at {$module_dir}/module.php this location." );
			}

			if ( ! file_exists( $module_widgets_dir . '/' . $module . '.php' ) ) {
				( new Stub(
					"{$widget_stub_name}.stub",
					array(
						'NAMESPACE'   => $widget_namespace,
						'CLASS'       => $class_name,
						'WIDGET_NAME' => $widget_prefix . $module,
						'VIEW_NAME'   => "{$module}.{$view_file_name}",
						'VIEW_BASE'   => $base_path  . 'views',
						'TITLE'       => $title,
						'TEXT_DOMAIN' => $text_domain,
					)
				) )->saveTo( $module_widgets_dir, $module . '.php' );

				\WP_CLI::success( "The module {$module}'s widget file has been created at {$module_widgets_dir}/{$module}.php this location." );
			}

			

			if ( ! file_exists( $module_view_dir . '/' . $view_file_name . '.' . $view_extension ) ) {
				( new Stub(
					"{$view_stub_name}.stub",
					array(
						'CLASS'           => $class_name,
						'TITLE'           => $title,
						'TEXT_DOMAIN'     => $text_domain,
					)
				) )->saveTo( $module_view_dir, $view_file_name . '.' . $view_extension );
	
				\WP_CLI::success( "The module {$module}'s widget file has been created at {$module_widgets_dir}/{$module}.php this location." );
			}

			if ( ! file_exists( $widgets_css_dir . '/' . $widget_prefix . $module . '.min.css' ) && ! key_exists( 'skip-css', $this->assoc_args ) && ! key_exists( 'skip:css', $this->assoc_args ) ) {
				( new Stub(
					'el-css.stub',
					array(
						'CLASS'       => $class_name,
						'WIDGET_NAME' => $widget_prefix . $module,
						'TITLE'       => $title,
						'TEXT_DOMAIN' => $text_domain,
					)
				) )->saveTo( $widgets_css_dir, $widget_prefix . $module . '.min.css' );

				\WP_CLI::success( "The module {$module}'s css file has been created at {$widgets_css_dir}/{$widget_prefix}{$module}.min.css this location." );
			}
		}
	}
}
