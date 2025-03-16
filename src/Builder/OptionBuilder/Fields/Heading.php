<?php
/**
 * Heading Field Builder
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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Heading Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Heading extends Field {

	/**
	 * Render the field
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
        $field = $this->field ?? [];
        $identifier = $this->identifier ?? '';

        $this->before();

        csmf_view( 'builder.fields.heading', compact( 'field', 'identifier' ) );

        $this->after();
	}
}
