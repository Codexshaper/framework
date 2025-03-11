<?php
/**
 * Media View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */

 $hidden_class = !$value['url'] ? 'hidden' : '';
?>

<div class="cxf--placeholder cxf--fieldset-wrap">
    <input 
        type="text" 
        name="<?php echo esc_attr( "{$name}[url]}" ); ?>" 
        value="<?php echo esc_attr( $value['url'] ); ?>" 
        class="cxf--url" 
        readonly="readonly"
        <?php cxf_get_string_attributes( $attributes ) ?> placeholder="<?php echo esc_attr( $placeholder ); ?>" />
    <button
        type="button"
        class="button cxf--a-btn cxf--a-btn-primary cxf--upload-button" 
        data-library="<?php esc_attr( $library ); ?>" 
        data-preview-size="<?php echo esc_attr( $args['preview_size'] ); ?>">
            <?php echo esc_html( $args['button_title'] ); ?>
    </button>
    <?php if ( ! isset( $args['preview'] ) || ! $args['preview'] ) : ?>
        <button type="button"class="button cxf--a-btn cxf--a-btn-danger cxf--upload-remove <?php echo esc_attr( $hidden_class ); ?>">
            <?php echo esc_html($args['remove_title']); ?>
        </button>
    <?php endif; ?>
</div>
<div class="cxf--input-wrap">
    <input 
        type="hidden" 
        class="cxf--media-id"
        name="<?php echo esc_attr( "{$name}[id]" ); ?>" 
        value="<?php echo esc_attr( $value['id'] ); ?>">
    <input 
        type="hidden"
        class="cxf--media-thumbnail"
        name="<?php echo esc_attr( "{$name}[thumbnail]" ); ?>" 
        value="<?php echo esc_attr( $value['thumbnail'] ); ?>" >
    <input 
        type="hidden"
        class="cxf--media-alt" 
        name="<?php echo esc_attr( "{$name}[alt]" ); ?>" 
        value="<?php echo esc_attr( $value['alt'] ); ?>" >
    <input 
        type="hidden" 
        class="cxf--media-title"
        name="<?php echo esc_attr( "{$name}[title]" ); ?>" 
        value="<?php echo esc_attr( $value['title'] ); ?>">
    <input 
        type="hidden" 
        class="cxf--media-description"
        name="<?php echo esc_attr( "{$name}[description]" ); ?>" 
        value="<?php echo esc_attr( $value['description'] ); ?>">
</div>