<?php
/**
 * Image Helper Trait file
 *
 * @category   Image
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Image;

use Elementor\Group_Control_Image_Size;

/**
 *  Image Helper trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Helper {

	/**
	 * Get URL of image by ID
	 *
	 * @param int    $image_id Image ID.
	 * @param array  $settings Image settings.
	 * @param string $size_prefix Size prefix.
	 *
	 * @return void
	 */
	public function get_image_size_src( $image_id, $settings, $size_prefix = 'image' ) {
		if ( ! $image_id ) {
			return '';
		}

		return Group_Control_Image_Size::get_attachment_image_src( $image_id, $size_prefix, $settings );
	}

	/**
	 * Get image attributes
	 *
	 * @param int    $image_id Image ID.
	 * @param string $size Image size.
	 *
	 * @return array
	 */
	public function get_size_image_attributes( $image_id, $size = 'full' ) {
		$url        = wp_get_attachment_image_url( $image_id, $size );
		$alt        = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$image_meta = wp_get_attachment_metadata( $image_id );
		$data       = array(
			'src'    => $url,
			'alt'    => $alt ?? 'Size Image',
			'width'  => $image_meta['width'] ?? 'auto',
			'height' => $image_meta['height'] ?? 'auto',
			'meta'   => $image_meta,
		);

		if ( isset( $image_meta['sizes'][ $size ] ) ) {
			$data['width']  = $image_meta['sizes'][ $size ]['width'];
			$data['height'] = $image_meta['sizes'][ $size ]['height'];
		}

		return $data;
	}

	/**
	 * Get image size
	 *
	 * @param int    $image_id Image ID.
	 * @param string $size Image size.
	 * @param array  $attributes Image attributes.
	 * @param bool   $is_lazy Is lazy load.
	 * @param bool   $is_custom_lazy Is custom lazy load.
	 *
	 * @return string
	 */
	public function get_size_image( $image_id, $size = 'full', $attributes = array(), $is_lazy = true, $is_custom_lazy = false ) {
		$size_image_attributes = $this->get_size_image_attributes( $image_id, $size );
		$attributes            = array_replace_recursive(
			array(
				'src'    => $size_image_attributes['src'],
				'alt'    => $size_image_attributes['alt'],
				'width'  => $size_image_attributes['width'],
				'height' => $size_image_attributes['height'],
			),
			$attributes
		);

		$fallback_url = $attributes['fallback_url'] ?? '';

		if ( ! $attributes['src'] && $fallback_url ) {
			$attributes['src'] = $fallback_url;
		}

		if ( isset( $attributes['fallback_url'] ) ) {
			unset( $attributes['fallback_url'] );
		}

		if ( ! $attributes['src'] ) {
			return;
		}

		foreach ( $attributes as $attribute => $value ) {
			if ( ! $value ) {
				unset( $attributes[ $attribute ] );
			}
		}

		if ( $is_lazy ) {
			return $this->get_lazy_load_image( $attributes['src'], $is_custom_lazy, $attributes );
		}

		$attributes_html = $this->generate_html_attributes( $attributes );

		return sprintf( '<img %s>', $attributes_html );
	}

	/**
	 * Get lazy load image
	 *
	 * @param string $url Image URL.
	 * @param bool   $is_custom_lazy Is custom lazy load.
	 * @param array  $attributes Image attributes.
	 *
	 * @return string
	 */
	public function get_lazy_load_image( $url, $is_custom_lazy = false, $attributes = array() ) {

		if ( empty( $url ) ) {
			return;
		}

		if ( isset( $attributes['src'] ) ) {
			unset( $attributes['src'] );
		}

		$attributes_html = $this->generate_html_attributes( $attributes );

		$img_src_attr = 'src';

		if ( $is_custom_lazy ) {
			wp_enqueue_script( 'csmf--lazy-load' );
			$img_src_attr = 'data-src';
		}

		if ( 'src' === $img_src_attr ) {
			$attributes_html .= sprintf( ' %s="%s"', esc_attr( 'loading' ), esc_attr( 'lazy' ) );
		}

		return sprintf(
			'<img %s="%s" %s>',
			esc_attr( $img_src_attr ),
			esc_url( $url ),
			$attributes_html,
		);
	}

	/**
	 * Generate HTML attributes
	 *
	 * @param array $attributes Attributes.
	 *
	 * @return string
	 */
	function generate_html_attributes( array $attributes ): string {
		$attrs = '';

		foreach ( $attributes as $attribute => $value ) {

			if ( ! $value ) {
				continue;
			}

			// Handle boolean attributes such as 'checked', 'disabled'
			if ( is_bool( $value ) ) {
				$attrs .= sprintf( ' %s', esc_attr( $attribute ) );
				continue;
			}

			$attrs .= sprintf( ' %s="%s"', esc_attr( $attribute ), esc_attr( $value ) );
		}

		return $attrs;
	}
}
