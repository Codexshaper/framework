<?php
/**
 * Text Field Builder
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
 * Text Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Text extends Field {

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
        $field_attributes = $this->field['field_'] ?? [];
        $type = $field_attributes['type'] ?? 'text';
        $name   = $this->get_name( $this->field, $this->identifier );
        $value = $this->value;
        $attributes = $this->get_attributes();

        $this->before();

        cmf_view( 'builder.fields.text', compact( 'type', 'name', 'value', 'attributes' ) );

        $this->after();
	}
}
