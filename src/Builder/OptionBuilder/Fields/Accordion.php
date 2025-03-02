<?php
/**
 * Accordion Field Builder
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
 * Accordion Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Accordion extends Field {

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {

        /**
         * Filter accordion block fields
         *
         * @since 1.0.0
         *
         * @param array $block_fields Accordion block fields.
         */
		$block_fields = apply_filters( 'cmf/builder/fields/accordion/block_fields', array( 'accordion' ) );

        $this->before();

        csmf_view( 'builder.fields.accordion', [
            'field' => $this->field,
            'value' => $this->value,
            'identifier'    => $this->identifier,
            'block_fields' => $block_fields,
        ] );

        $this->after();
	}
}
