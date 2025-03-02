<?php
/**
 * Field Builder
 *
 * @category   Builder
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */

namespace CodexShaper\Framework\Builder\OptionBuilder;

use CodexShaper\Framework\Foundation\Builder\Field as BaseField;

/**
 * Field Option class
 *
 * @category   Class
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 */
class Field extends BaseField {

	/**
	 * Create option field.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $field Field.
	 * @param string $value Option value.
	 * @param string $identifier Option identifier.
	 * @param string $where Where the field is.
	 * @param string $parent Parent field.
	 *
	 * @return void
	 */
	public static function render( $field, $value = '', $identifier = '', $where = '', $parent = '' ) {

		$field_type = $field['type'] ?? '';
		$errors     = $field['errors'] ?? array();

		if ( ! $field_type ) {
			$errors = "You must provide field type.";
			csmf_view('builder.fields.error', compact('errors'));
			return;
		}

		$class_name  = csmf_classify( $field_type );
		$field_class = "CodexShaper\Framework\Builder\OptionBuilder\Fields\\{$class_name}";

		if ( ! class_exists( $field_class ) ) {
			$errors = "Field doesn't exists.";
			csmf_view('builder.fields.error', compact('errors'));
			return;
		}

		$value             = ! isset($value) && isset( $field['default'] ) ? $field['default'] : $value;
		$value             = $field['value'] ?? $value;
		$title             = $field['title'] ?? '';
		$subtitle          = $field['subtitle'] ?? '';
		$class             = $field['class'] ?? '';
		$depend_attributes = '';
		$error_messsage    = '';
		$dependencies      = $field['dependencies'] ?? array();

		if ( ! empty( $dependencies ) ) {
			$data_controller = '';
			$data_condition  = '';
			$data_value      = '';
			$depends         = array();
			$actions         = array();
			foreach ( $dependencies as $dependency ) {
				$parent_id       = $dependency['parent_id'] ?? $identifier;
				$data_controller = $dependency['controller'] ?? '';
				$data_condition  = $dependency['condition'] ?? '==';
				$data_value      = $dependency['value'] ?? '';
				$data_action     = $dependency['action'] ?? 'show';

				if ( ! $data_controller ) {
					continue;
				}

				$data_controller = "{$parent_id}_{$data_controller}";

				if ( ! isset( $depends[ $data_controller ] ) ) {
					$format = '#%s:%s';
					if ( $data_value ) {
						$format .= ':%s';
					}
					$depends[ $data_controller ] = sprintf(
						$format,
						$data_controller,
						$data_condition,
						$data_value,
					);
				}

				if ( ! in_array( $data_action, $actions ) ) {
					$actions[] = $data_action;
				}
			}

			$data_dependency = implode( '|', $depends );
			$data_action     = implode( '|', $actions );

			$depend_attributes = sprintf(
				'data-depends="%s" data-action="%s"',
				esc_attr( $data_dependency ),
				esc_attr( $data_action ),
			);

		}
		
		csmf_view(
			'builder.field',
			compact(
				'field_type',
				'field_class',
				'field',
				'value',
				'title',
				'subtitle',
				'class',
				'depend_attributes',
				'error_messsage',
				'identifier',
				'where',
				'parent',
			)
		);
	}

	public static function build( $data = array() ) {
		$value = '';
		$post_id = $data['post_id'] ?? 0;
		$field = $data['field'] ?? array();
		$identifier = $data['identifier'] ?? '';
		$options = $data['options'] ?? array();
		$parent = $data['parent'] ?? '';
		$is_serialize = $data['is_serialize'] ?? true;

		if ( ! empty( $field['id'] ) ) {

			$field['default'] = $field['default'] ?? '';

			if ( isset($args['defaults'][$field['id']]) ) {
				$field['default'] = $args['defaults'][$field['id']];
			}

			if (isset( $options[$field['id']] )) {
				$value = $options[$field['id']];
			}
		}

		if ($post_id) {
			$value = static::get_value( $post_id, $field, $identifier, $options, $is_serialize );
		}

		static::render( $field, $value, $identifier, $parent );
	}
}
