<?php
/**
 * Media Field Builder
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
 * Media Field class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

class Media extends Field {

	/**
	 * Render Media field
	 *
	 * @return void
	 */
	public function render() {
		$args = wp_parse_args( $this->field, array(
			'url'            => true,
			'preview'        => true,
			'library'        => array(),
			'button_title'   => 'Upload',
			'remove_title'   => 'Remove',
			'preview_size'   => 'thumbnail',
		  ) );

		$this->before();

		$library = $args['library'] ?? array();

		if ( ! is_array( $library ) ) {
			$library = array_filter( (array) $library );
		}

		$library = implode( ',', $library );
	
		$default_values = array(
			'url'         => '',
			'id'          => '',
			'width'       => '',
			'height'      => '',
			'thumbnail'   => '',
			'alt'         => '',
			'title'       => '',
			'description' => ''
		);
	
		// Fallback value. 
		if ( is_numeric( $this->value ) ) {

			$this->value  = array(
				'id'        => $this->value,
				'url'       => wp_get_attachment_url( $this->value ),
				'thumbnail' => wp_get_attachment_image_src( $this->value, 'thumbnail', true )[0],
			);

		}

		$this->value = wp_parse_args( $this->value, $default_values );
		$preview_src = $args['preview_size'] === 'thumbnail' ? $this->value['url'] : $this->value['thumbnail'];
		$placeholder = $this->field['placeholder'] ?? 'Not selected';

		if ( $args['preview'] ) {
			csmf_view(
				'builder.fields.upload.preview',
				array(
					'args' => $args,
					'src'    => $preview_src,
				)
			);
		}

		csmf_view(
			'builder.fields.media',
			array(
				'name'       => $this->get_name( $this->field, $this->identifier ),
				'value'      => $this->value,
				'attributes' => $this->get_attributes(),
				'library'    => $library,
				'args'       => $args,
				'placeholder' => $placeholder,
			)
		);

		$this->after();
	}
}
