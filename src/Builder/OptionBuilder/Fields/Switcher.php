<?php
/**
 * Switcher Field Builder
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
 * Switcher Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Switcher extends Field {

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
        $identifier = $this->identifier;
        $value = $this->value;
        $field = $this->field;
        $name   = $this->get_name( $this->field, $this->identifier );
        $attributes = $this->get_attributes();
        $this->before();

        csmf_view( 'builder.fields.switcher', compact(
                'identifier',
                'value',
                'field',
                'name',
                'attributes',
            )
        );

        $this->after();
	}
}
