<?php
/**
 * Select Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder\OptionBuilder\Fields;

use CodexShaper\Framework\Foundation\Builder\Field;

/**
 * Select Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class Select extends Field {

	/**
	 * Render Select field
	 *
	 * @return void
	 */
	public function render() {

		$args = wp_parse_args(
			$this->field,
			array(
				'placeholder' => '',
				'multiple'    => false,
				'sortable'    => false,
				'ajax'        => false,
				'settings'    => array(),
				'query_args'  => array(),
			)
		);

		$this->value = ( is_array( $this->value ) ) ? $this->value : array_filter( (array) $this->value );

		$this->before();

		if ( isset( $this->field['options'] ) ) {

			$is_sortable 			= $args['sortable'] ?? false;
			$is_ajax 				= $args['ajax'] ?? false;
			$is_multiple 			= $args['multiple'] ?? false;
			$is_choice 				= $args['choice'] ?? $is_multiple ? true : false;
			$placeholder 			= $args['placeholder'] ?? '';
			$settings 				= $args['settings'] ?? array();
			$multiple_name    		= $is_multiple ? '[]' : '';
			$multiple_attr    		= $is_multiple ? ' multiple' : '';
			$placeholder_attr 		= $is_choice && $placeholder ? ' data-placeholder="' . esc_attr( $placeholder ) . '"' : '';
			$name             		= $this->get_name( $this->field, $this->identifier, $multiple_name );
			$pseudo_attr      		= '';
			$value            		= $this->value;
			$attributes       		= $this->get_attributes();
			$options          		= $this->field['options'];
			$errors           		= array();

			if ( ! is_array( $options ) || empty( $options ) ) {
				$errors[] = $this->field['empty_message'] ?? 'No data available.';
				cmf_view( 'builder.fields.error', compact( 'errors' ) );
				return;
			}

			cmf_view(
				'builder.fields.select',
				compact(
					'is_choice',
					'pseudo_attr',
					'name',
					'value',
					'attributes',
					'multiple_attr',
					'placeholder_attr',
					'args',
					'options',
				)
			);
		}

		$this->after();
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	public function enqueue() {
		if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
	}
}
