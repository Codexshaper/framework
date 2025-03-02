<?php
/**
 * Upload Field Builder
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
 * Upload Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

class Upload extends Field {

	/**
	 * Render Upload field
	 *
	 * @return void
	 */
	public function render() {
		$args = wp_parse_args(
			$this->field,
			array(
				'library'        => array(),
				'preview'        => false,
				'button_title'   => esc_html__( 'Upload', 'codexshaper-framework' ),
				'remove_title'   => esc_html__( 'Remove', 'codexshaper-framework' ),
			)
		);

		$this->before();

		$library = $args['library'] ?? array();

		if ( ! is_array( $library ) ) {
			$library = array_filter( (array) $library );
		}

		$library = implode( ',', $library );
		$allowed_mimes = array( 'jpg', 'jpeg', 'gif', 'png', 'svg', 'webp' );

		if ( isset($args['preview']) && $args['preview'] ) {

			$preview_type   = '';
			$preview_src    = '';

			if ($this->value) {
				$preview_type = strtolower( substr( strrchr( $this->value, '.' ), 1 ) );
			}

			if ($preview_type && in_array( $preview_type,  $allowed_mimes) ) {
				$preview_src =  $this->value;
			}

			csmf_view(
				'builder.fields.upload.preview',
				array(
					'args' => $args,
					'src'    => $preview_src,
				)
			);
		}

		csmf_view(
			'builder.fields.upload.button',
			array(
				'name'       => $this->get_name( $this->field, $this->identifier ),
				'value'      => $this->value,
				'attributes' => $this->get_attributes(),
				'library'    => $library,
				'args'       => $args,
			)
		);

		$this->after();
	}
}
