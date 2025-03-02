<?php
/**
 * Base Skin file
 *
 * @category   Base
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Elementor;

use Elementor\Skin_Base;
use Elementor\Widget_Base;

// Exit if access directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Base Skin class for element bucket
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
abstract class Skin extends Skin_Base {

	/**
	 * Skin stack.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $stack = 'csmf--post';

	/**
	 * Skin sections.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $sections = array(
		'section_layout' => array(
			'before_section_end' => array(
				'register_controls',
			),
		),
	);

	/**
	 * Registered controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $registered_controls = array();

	/**
	 * Skin constructor.
	 *
	 * Initializing the skin class.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct( $parent ) {
		$this->parent = $parent;
		parent::__construct( $parent );
		$this->_register_controls_actions();
	}

	/**
	 * Register skin controls actions.
	 *
	 * Run on init and used to register new skins to be injected to the widget.
	 * This method is used to register new actions that specify the location of
	 * the skin in the widget.
	 *
	 * Example usage:
	 * `add_action( 'elementor/element/{widget_id}/{section_id}/before_section_end', [ $this, 'register_controls' ] );`
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		foreach ( $this->sections as $section => $actions ) {
			foreach ( $actions as $action => $callbacks ) {

				$hook = "elementor/element/{$this->stack}/{$section}/{$action}";

				if ( ! is_array( $callbacks ) ) {
					$callbacks = (array) $callbacks;
				}

				// Check if the hook is already registered.
				if ( isset( $this->registered_controls[ $hook ] ) ) {
					continue;
				}

				add_action(
					$hook,
					function ( $widget ) use ( $callbacks, $action ) {
						foreach ( $callbacks as $callback => $args ) {

							if ( is_numeric( $callback ) && is_string( $args ) ) {
								$callback = $args;
								$args     = array();
							}

							if ( ! method_exists( $this, $callback ) ) {
								continue;
							}

							$is_section = false;

							if ( ! isset( $args['is_section'] ) && ( $action === 'before_section_start' || $action === 'after_section_end' ) ) {
								$is_section = true;
							}

							$args['is_section']      = $args['is_section'] ?? $is_section;
							$args['action']          = $args['action'] ?? $action;
							$args['section_prefix']  = str_replace( '-', '_', $args['section_prefix'] ?? $this->stack );
							$args['section_prefix'] .= '_';

							$this->$callback( $widget, $args );
						}
					}
				);

				// Mark the hook as registered to prevent duplicate registration.
				$this->registered_controls[ $hook ] = true;

			}
		}
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	public function register_controls( Widget_Base $widget, $args ) {
		$this->parent = $widget;
	}
}
