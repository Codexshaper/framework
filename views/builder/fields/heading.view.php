<?php
/**
 * Accordion View
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
    exit; // Exit if accessed directly.
}

$tag = $field['tag'] ?? 'h3';
$id = $field['id'] ?? $identifier;
$class = $field['class'] ?? 'csmf--heading';
$content = $field['content'] ?? '';

echo sprintf( 
    '<%s id="%s" class="%s">%s</%s>', 
    esc_attr( $tag ), 
    esc_attr( $id ), 
    esc_attr( $class ), 
    esc_attr( $content ), 
    esc_attr( $tag ) 
);
?>

