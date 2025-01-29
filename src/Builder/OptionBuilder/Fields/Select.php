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
				'chosen'      => false,
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

			$is_chosen 				= $args['chosen'] ?? false;
			$is_sortable 			= $args['sortable'] ?? false;
			$is_ajax 				= $args['ajax'] ?? false;
			$is_multiple 			= $args['multiple'] ?? false;
			$placeholder 			= $args['placeholder'] ?? '';
			$settings 				= $args['settings'] ?? array();
			$chosen_rtl_class   	= is_rtl() ? ' chosen-rtl' : '';
			$multiple_name    		= $is_multiple ? '[]' : '';
			$multiple_attr    		= $is_multiple ? ' multiple' : '';
			$chosen_sortable_class  = $is_chosen && $is_sortable ? ' cxf--chosen-sortable' : '';
			$chosen_ajax_class      = $is_chosen && $is_ajax ? ' cxf--chosen-ajax' : '';
			$placeholder_attr 		= $is_chosen && $placeholder ? ' data-placeholder="' . esc_attr( $placeholder ) . '"' : '';
			$field_class      		= $is_chosen ? ' class="cxf--chosen' . esc_attr( $chosen_rtl_class . $chosen_sortable_class . $chosen_ajax_class ) . '"' : '';
			$name             		= $this->get_name( $this->field, $this->identifier, $multiple_name );
			$pseudo_name      		= $is_chosen && $is_multiple ? '_pseudo' : '';
			$pseudo_attr      		= '';
			$value            		= $this->value;
			$attributes       		= $this->get_attributes();
			$options          		= $this->field['options'];
			$chosen_data_attr 		= $is_chosen && ! empty( $settings ) ? ' data-chosen-settings="' . esc_attr( wp_json_encode( $settings ) ) . '"' : '';
			$errors           		= array();

			if ( ( ! is_array( $options ) || empty( $options ) ) && ( ! $is_chosen || ! $is_ajax ) ) {
				$errors[] = $this->field['empty_message'] ?? 'No data available.';
				cxf_view( 'builder.fields.error', compact( 'errors' ) );
				return;
			}

			cxf_view(
				'builder.fields.select',
				compact(
					'field_class',
					'pseudo_name',
					'pseudo_attr',
					'name',
					'value',
					'attributes',
					'multiple_attr',
					'placeholder_attr',
					'args',
					'options',
					'chosen_data_attr',
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
