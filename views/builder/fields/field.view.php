<?php
/**
 * Field View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    die;
}

use CodexShaper\Framework\Builder\OptionBuilder\Field;

$value = '';
$post_id = $post_id ?? 0;

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
    $value = Field::get_value( $post_id, $field, $identifier, $options );
}

Field::render( $field, $value, $identifier, $parent );