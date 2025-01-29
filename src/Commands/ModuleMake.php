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

		foreach ( $this->args as $arg ) {

			$title                = cxf_title( $arg );
			$class_name           = str_replace( ' ', '_', $title );
			$module_name          = str_replace( ' ', '', $title );
			$module_namespace     = 'CodexShaper\Framework\Widgets\Elementor\Modules\\' . $module_name;
			$widget_namespace     = 'CodexShaper\Framework\Widgets\Elementor\Modules\\' . $module_name . '\Widgets';
			$module_stub_name     = 'el-module';
			$widget_stub_name     = 'el-widget';
			$widget_category      = 'cxf--widget';
			$text_domain          = 'codexshaper-framework';
			$cxf_eb_module_prefix = defined( 'CXF_ELEMENTOR_MODULE_PREFIX' ) ? CXF_ELEMENTOR_MODULE_PREFIX . '-' : '';
			$cxf_eb_widget_prefix = defined( 'CXF_ELEMENTOR_WIDGET_PREFIX' ) ? CXF_ELEMENTOR_WIDGET_PREFIX . '-' : '';
			$module               = str_replace( ' ', '-', strtolower( $title ) );
			$module_dir           = cxf_plugin_base_path() . "widgets/elementor/modules/{$module}";
			$module_widgets_dir   = cxf_plugin_base_path() . "widgets/elementor/modules/{$module}/widgets";
			$widgets_css_dir      = cxf_plugin_base_path() . 'widgets/elementor/assets/css';
			$widgets_js_dir       = cxf_plugin_base_path() . 'widgets/elementor/assets/js';

			if ( ! is_dir( $module_widgets_dir ) ) {
				wp_mkdir_p( $module_widgets_dir );
				\WP_CLI::success( "The module {$module}'s module directory has been created at $module_dir this location." );
				\WP_CLI::success( "The module {$module}'s widgets directory has been created at $module_widgets_dir this location." );
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
					'MODULE_NAME'  => $cxf_eb_module_prefix . $module,
					'WIDGET_NAME'  => $cxf_eb_widget_prefix . $module,
					'TEXT_DOMAIN'  => $text_domain,
				)
			) )->saveTo( $module_dir, 'module.php' );

			\WP_CLI::success( "The module {$module}'s module file has been created at {$module_dir}/module.php this location." );

			( new Stub(
				"{$widget_stub_name}.stub",
				array(
					'NAMESPACE'       => $widget_namespace,
					'CLASS'           => $class_name,
					'WIDGET_NAME'     => $cxf_eb_widget_prefix . $module,
					'TITLE'           => $title,
					'WIDGET_CATEGORY' => $widget_category,
					'TEXT_DOMAIN'     => $text_domain,
				)
			) )->saveTo( $module_widgets_dir, $module . '.php' );

			\WP_CLI::success( "The module {$module}'s widget file has been created at {$module_widgets_dir}/{$module}.php this location." );

			if ( ! key_exists( 'skip-css', $this->assoc_args ) && ! key_exists( 'skip:css', $this->assoc_args ) ) {
				( new Stub(
					'el-css.stub',
					array(
						'CLASS'           => $class_name,
						'WIDGET_NAME'     => $cxf_eb_widget_prefix . $module,
						'TITLE'           => $title,
						'WIDGET_CATEGORY' => $widget_category,
						'TEXT_DOMAIN'     => $text_domain,
					)
				) )->saveTo( $widgets_css_dir, $cxf_eb_widget_prefix . $module . '.min.css' );

				\WP_CLI::success( "The module {$module}'s css file has been created at {$widgets_css_dir}/{$cxf_eb_widget_prefix}{$module}.min.css this location." );
			}

			if ( key_exists( 'slider', $this->assoc_args ) ) {
				( new Stub(
					'el-slider-js.stub',
					array(

						'WIDGET_NAME'  => $cxf_eb_widget_prefix . $module,
						'WIDGET_SKINS' => '[]',
					)
				) )->saveTo( $widgets_js_dir, $cxf_eb_widget_prefix . $module . '.min.js' );

				\WP_CLI::success( "The module {$module}'s css file has been created at {$widgets_js_dir}/{$cxf_eb_widget_prefix}{$module}.min.css this location." );
			}
		}
	}
}
