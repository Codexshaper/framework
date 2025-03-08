<?php
/**
 * Base Module file
 *
 * @category   Base
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Module as BaseModule;
use Elementor\Widget_Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base module class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
abstract class Module extends BaseModule {

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();

		add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_styles' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );
		add_action( 'elementor/ajax/register_actions', array( $this, 'register_ajax_actions' ) );
		add_action( 'elementor/controls/register', array( $this, 'register_controls' ) );
		add_action( 'elementor/init', array( $this, 'register_skins' ) );
	}

	/**
	 * Get the module's associated skins.
	 *
	 * @return string[]
	 */
	public function get_skins() {
		return array();
	}

	/**
	 * Get asset base url
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string
	 */
	public function get_assets_base_url(): string {
		return csmf_plugin_base_url() . 'widgets/elementor/';
	}

	/**
	 * Regsiter styles for current module.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function register_styles() {}

	/**
	 * Regsiter scripts for current module.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function register_scripts() {}

	/**
	 * Regsiter controls for current module.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param Ajax $ajax_manager
	 *
	 * @return mixed
	 */
	public function register_ajax_actions( $ajax_manager ) {}

	/**
	 * Regsiter controls for current module.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param Controls_Manager $controls_manager The control manager.
	 *
	 * @return mixed
	 */
	public function register_controls( Controls_Manager $controls_manager ) {}

	/**
	 * Regsiter skins for current module.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function register_skins() {
		$skins = $this->get_skins();

		/**
		 * Widget skins.
		 *
		 * Fires when CodexShaper Framework module is being initialized.
		 *
		 * The dynamic portion of the hook name, `$module_name`, refers to the module name.
		 *
		 * @since 1.0.0
		 *
		 * @param array $skins The current skins.
		 */
		$skins = apply_filters( "csmf/module/{$this->get_name()}/skins_init", $skins );

		foreach ( $skins as $widget_name => $skin_class ) {
			// Prepare skin class if passed only skin class name.
			if ( ! class_exists( $skin_class ) ) {
				$skin_class = $this->get_reflection()->getNamespaceName() . '\Skins\\' . $skin_class;
			}
			// Start new loop if skin class doesn't exists.
			if ( ! class_exists( $skin_class ) ) {
				break;
			}
			/*
			 * Check widget name provided or not. If not provided then prepare widget name from key if
			 * key is string and not numeric.
			 */
			if ( ! is_numeric( $widget_name ) && is_string( $widget_name ) ) {
				if ( ! class_exists( $widget_name ) ) {
					$widget_class = $this->get_reflection()->getNamespaceName() . '\Widgets\\' . $widget_name;
				}

				if ( class_exists( $widget_class ) ) {
					$widget_instance = new $widget_class();
					if ( $widget_instance instanceof Widget_Base ) {
						$widget_name = $widget_instance->get_name();
					}
				}

				$this->add_skin( $widget_name, $skin_class );

				break;
			}

			// If not specify widget name or class.
			$widgets = $this->get_widgets();

			if ( ! is_array( $widgets ) || empty( $widgets ) ) {
				continue;
			}

			foreach ( $widgets as $widget_class ) {
				if ( ! class_exists( $widget_class ) ) {
					$widget_class = $this->get_reflection()->getNamespaceName() . '\Widgets\\' . $widget_class;
				}

				if ( ! class_exists( $widget_class ) ) {
					break;
				}

				$widget_instance = new $widget_class();

				if ( $widget_instance instanceof Widget_Base ) {
					$widget_name = $widget_instance->get_name();
					$this->add_skin( $widget_name, $skin_class );
				}
			}
		}
	}

	/**
	 * Get allowed widgets.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Allowed widgets.
	 */
	protected function add_skin( $widget_name, $skin_class ) {
		add_action(
			"elementor/widget/{$widget_name}/skins_init",
			function ( $widget ) use( $skin_class ) {
				$widget->add_skin( new $skin_class( $widget ) );
			}
		);
	}
}
