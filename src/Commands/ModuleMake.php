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
class ModuleMake extends Command {

	/**
	 * Name
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var string The command name.
	 */
	public $name = 'cxf-el-module:make';

	/**
	 * Handle Command
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function handle() {

		$module_config = cxf_config( 'module.widget.elementor' );
		$app_config   = cxf_config( 'app' );
		$plugin_namespace = $app_config['plugin_namespaces'] ?? '';

		foreach ( $this->args as $arg ) {

			$title                	= cxf_title( $arg );
			$class_name           	= str_replace( ' ', '_', $title );
			$module_name          	= str_replace( ' ', '', $title );
			$base_path	 			= trailingslashit(untrailingslashit($module_config['base_path'] ?? cxf_plugin_base_path() . "widgets/elementor"));
			$base_namespace	 		= $module_config['namespace'] ?? $plugin_namespace . 'Widgets\\Elementor\\Modules';
			$module_namespace     	= "{$base_namespace}\\{$module_name}";
			$widget_namespace     	= "{$module_namespace}\\Widgets";
			$module_stub_name     	= $module_config['module_stub_name'] ?? 'el-module';
			$module_config_stub_name = $module_config['module_config_stub_name'] ?? 'el-module-config';
			$widget_stub_name     	= $module_config['widget_stub_name'] ?? 'el-widget';
			$view_stub_name     	= $module_config['view_stub_name'] ?? 'el-view';
			$view_file_name     	= $module_config['view_file_name'] ?? 'content';
			$view_extension    		= $module_config['view_extension'] ?? 'view.php';
			$widget_category      	= $module_config['widget_category'] ?? 'cxf--widget';
			$text_domain          	= $app_config['plugin_text_domain'] ?? 'codexshaper-framework';
			$module_prefix 			= $module_config['module_prefix'] ?? '';
			$widget_prefix 			= $module_config['widget_prefix'] ?? '';
			$module               	= str_replace( ' ', '-', strtolower( $title ) );
			$module_dir           	= $base_path . "modules/{$module}";
			$module_widgets_dir   	= $base_path . "modules/{$module}/widgets";
			$module_view_dir        = $base_path . "views/{$module}";
			$module_view_file 		= $view_file_name . '.' . $view_extension;
			$widgets_css_dir      	= $base_path . 'assets/css';
			$widgets_js_dir       	= $base_path . 'assets/js';
			

			if ( ! is_dir( $module_widgets_dir ) ) {
				wp_mkdir_p( $module_widgets_dir );
				\WP_CLI::success( "The module {$module}'s module directory has been created at $module_dir this location." );
				\WP_CLI::success( "The module {$module}'s widgets directory has been created at $module_widgets_dir this location." );
			}

			if ( ! is_dir( $module_view_dir ) ) {
				wp_mkdir_p( $module_view_dir );
				\WP_CLI::success( "The module {$module}'s view directory has been created at $module_view_dir this location." );
			}

			if ( key_exists( 'skip-css', $this->assoc_args ) || key_exists( 'skip:css', $this->assoc_args ) ) {
				$module_stub_name .= '-skip-css';
				$widget_stub_name .= '-skip-css';
			}

			if ( key_exists( 'query', $this->assoc_args ) || key_exists( 'query', $this->assoc_args ) ) {
				$widget_stub_name .= '-query';
			}

			if ( key_exists( 'slider', $this->assoc_args ) || key_exists( 'slider', $this->assoc_args ) ) {
				$module_stub_name .= '-slider';
				$widget_stub_name .= '-slider';
			}

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

			( new Stub(
				"{$module_config_stub_name}.stub",
				array(
					'MODULE_NAME'  => $module,
					'MODULE_SLUG'  => $module,
					'WIDGET_CLASS' => $class_name,
					'TITLE'        => $title,
					'VERSION'      => defined( 'CXF_VERSION' ) ? CXF_VERSION : CXF_APP_VERSION,
					'ICON'         => 'eicon-archive',
				)
			) )->saveTo( $module_dir, 'module.json' );

			\WP_CLI::success( "The module {$module}'s config file has been created at {$module_dir}/module.json this location." );

			( new Stub(
				"{$widget_stub_name}.stub",
				array(
					'NAMESPACE'       => $widget_namespace,
					'CLASS'           => $class_name,
					'WIDGET_NAME'     => $widget_prefix . $module,
					'VIEW_NAME'       => "{$module}.{$view_file_name}",
					'TITLE'           => $title,
					'WIDGET_CATEGORY' => $widget_category,
					'TEXT_DOMAIN'     => $text_domain,
				)
			) )->saveTo( $module_widgets_dir, $module . '.php' );

			\WP_CLI::success( "The module {$module}'s widget file has been created at {$module_widgets_dir}/{$module}.php this location." );

			( new Stub(
				"{$view_stub_name}.stub",
				array(
					'CLASS'           => $class_name,
					'TITLE'           => $title,
					'TEXT_DOMAIN'     => $text_domain,
				)
			) )->saveTo( $module_view_dir, $module_view_file );

			\WP_CLI::success( "The module {$module}'s view file has been created at {$module_view_dir}/{$module_view_file} this location." );

			

			if ( ! key_exists( 'skip-css', $this->assoc_args ) && ! key_exists( 'skip:css', $this->assoc_args ) ) {
				( new Stub(
					'el-css.stub',
					array(
						'CLASS'           => $class_name,
						'WIDGET_NAME'     => $widget_prefix . $module,
						'VIEW_NAME'       => "{$module}.{$view_file_name}",
						'TITLE'           => $title,
						'WIDGET_CATEGORY' => $widget_category,
						'TEXT_DOMAIN'     => $text_domain,
					)
				) )->saveTo( $widgets_css_dir, $widget_prefix . $module . '.min.css' );

				\WP_CLI::success( "The module {$module}'s css file has been created at {$widgets_css_dir}/{$widget_prefix}{$module}.min.css this location." );
			}

			if ( key_exists( 'slider', $this->assoc_args ) ) {
				( new Stub(
					'el-slider-js.stub',
					array(
						'WIDGET_NAME'  => $widget_prefix . $module,
						'VIEW_NAME'       => "{$module}.{$view_file_name}",
						'WIDGET_SKINS' => '[]',
					)
				) )->saveTo( $widgets_js_dir, $widget_prefix . $module . '.min.js' );

				\WP_CLI::success( "The module {$module}'s css file has been created at {$widgets_js_dir}/{$widget_prefix}{$module}.min.css this location." );
			}
		}
	}
}
