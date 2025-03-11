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
$tag = $field['tag'] ?? 'h3';
$id = $field['id'] ?? $identifier;
$class = $field['class'] ?? 'cxf--heading';
$content = $field['content'] ?? '';

echo sprintf( '<%s id="%s" class="%s">%s</%s>', $tag, $id, $class, $content, $tag );
?>

