<?php
/**
 * Levels Trait file
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Foundation\Traits\Builder;

/**
 *  Level trait
 *
 * @category   Trait
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
trait Field {

	/**
	 * Get field name
	 *
	 * @param array  $field Field.
	 * @param string $id Option identifier.
	 * @param string $suffix Suffix.
	 *
	 * @since 1.0.0
	 *
	 * @return string Field name.
	 */
	public static function get_name( $field, $id, $suffix = '' ) {

		if ( ! $field ) {
			echo 'You must provide valid field value';
			return;
		}

		if ( ! is_array( $field ) && ! is_object( $field ) ) {
			echo 'You must provide array or object as a field.';
			return;
		}

		if ( is_object( $field ) ) {
			$field = (array) $field;
		}

		$field_id = $field['id'] ?? '';
		$id       = $field_id ? "{$id}[{$field_id}]" : $id;
		$name     = $field['name'] ?? $id;

		$prefix = $field['name_prefix'] ?? '';

		if ( ! empty( $prefix ) ) {
			$suffix = str_replace( '[', "[{$prefix}", $suffix );
		}

		return $name . $suffix;
	}

	/**
	 * Get field value
	 *
	 * @param int    $post_id Post ID.
	 * @param array  $field Field.
	 * @param string $metabox_id Metabox ID.
	 * @param array  $options Options.
	 *
	 * @since 1.0.0
	 *
	 * @return string Field value.
	 */
	public static function get_value( $post_id, $field, $metabox_id = '', $options = array(), $is_serialize = true ) {

		$value = '';

		if ( ! $post_id || ! isset( $field['id'] ) || ! $field['id'] ) {
			return $value;
		}

		$data  = get_post_meta( $post_id, $field['id'] );
		$value = $data[0] ?? '';

		if ( $metabox_id && $is_serialize ) {
			$data  = get_post_meta( $post_id, $metabox_id, true );
			$value = $data[ $field['id'] ] ?? '';
		}

		if ( ! $value ) {
			$value = $field['default'] ?? '';
		}

		return $value;
	}

	/**
	 * Get field attributes
	 *
	 * @param array $atts Attributes.
	 *
	 * @since 1.0.0
	 *
	 * @return string Field attributes.
	 */
	public function get_attributes( $atts = array() ) {

		$id          = $this->field['id'] ?? '';
		$placeholder = $this->field['placeholder'] ?? '';
		$attributes  = $this->field['attributes'] ?? array();

		if ( $id ) {
			$attributes['id'] = $this->identifier ? "{$this->identifier}_{$id}" : $id;
		}

		// Add `placeholder` if available.
		if ( $placeholder ) {
			$attributes['placeholder'] = $placeholder;
		}

		// Merge additional attributes with default attributes.
		$attributes = wp_parse_args( $attributes, $atts );

		// Build the attributes string
		return array_map(
			function ( $key, $value ) {
				if ( ! $value || $value === 'only-key' ) {
					return esc_attr( $key ); // Sanitize the key
				}
				return sprintf( '%s="%s"', esc_attr( $key ), esc_attr( $value ) ); // Sanitize key and value
			},
			array_keys( $attributes ),
			$attributes
		);
	}

	/**
	 * Field before
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Field before.
	 */
	public function before( $render = false ) {
		$before = $this->field['before'] ?? '';
		$name   = $this->get_name( $this->field, $this->identifier );
		if ( $before ) {
			$before = "<div class='csmf--field-before'>{$before}</div>";
		}

		$before = apply_filters( "csmf/option/field/{$name}/before", $before );

		if ( $render ) {
			return $before; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional unescaped output.
		}

		echo $before; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional unescaped output.
	}

	/**
	 * Field after
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Field after.
	 */
	public function after( $render = false ) {
		$name        = $this->get_name( $this->field, $this->identifier );
		$after       = $this->field['after'] ?? '';
		$description = $this->field['description'] ?? $this->field['desc'] ?? '';
		$help        = $this->field['help'] ?? '';
		$error       = $this->field['error'] ?? '';

		if ( $after ) {
			$after = "<div class='csmf--field-after'>{$after}</div>";
		}

		if ( $description ) {
			$after .= "<div class='csmf--field-description'>{$description}</div>";
		}

		if ( $help ) {
			$after .= "<div class='csmf--field-help' data-help='{$help}'><i class='fas fa-question-circle'></i></div>";
		}

		if ( $error ) {
			$after .= "<div class='csmf--field-error'>{$error}</div>";
		}

		$after = apply_filters( "csmf/option/field/{$name}/after", $after );

		if ( $render ) {
			return $after; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional unescaped output.;
		}

		echo $after; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional unescaped output.;
	}
}
