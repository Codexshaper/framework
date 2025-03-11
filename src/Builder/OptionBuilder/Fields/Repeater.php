<?php
/**
 * Callback Field Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder\OptionBuilder\Fields;

use CodexShaper\Framework\Foundation\Builder\Field as BaseField;

/**
 * Callback Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Repeater extends BaseField {

	/**
	 * Render Repeater field
	 *
	 * @return void
	 */
	public function render() {
		$options = wp_parse_args(
			$this->field,
			array(
				'max'          => 0,
				'min'          => 0,
				'button_title' => '<i class="fas fa-plus-circle"></i>',
			)
		);

		if ( preg_match( '/' . preg_quote( '[' . $this->field['id'] . ']' ) . '/', $this->identifier ) ) {
			echo '<div class="cxf--notice cxf--notice-danger">' . esc_html__( 'Error: Field ID conflict.', 'codexshaper-framework' ) . '</div>';
			return;
		}

		$this->before();

		cxf_view(
			'builder.fields.repeater', 
			array(
				'identifier' => $this->identifier,
				'value' => $this->value,
				'field' => $this->field, 
				'options' => $options 
			)
		);
		
		$this->after();
	}

	/**
	 * Enqueue control scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the control.
	 *
	 * @since 1.5.0
	 * @access public
	 */
	public function enqueue_scripts() {
		if ( ! wp_script_is( 'jquery-ui-sortable' ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
	}
}
