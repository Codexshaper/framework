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

<div class="csmf--placeholder csmf--fieldset-wrap">
    <input 
        type="text" 
        name="<?php echo esc_attr( "{$name}[url]}" ); ?>" 
        value="<?php echo esc_attr( $value['url'] ); ?>" 
        class="csmf--url" 
        readonly="readonly"
        <?php csmf_get_string_attributes( $attributes ) ?> placeholder="<?php echo esc_attr( $placeholder ); ?>" />
    <button
        type="button"
        class="button csmf--a-btn csmf--a-btn-primary csmf--upload-button" 
        data-library="<?php esc_attr( $library ); ?>" 
        data-preview-size="<?php echo esc_attr( $args['preview_size'] ); ?>">
            <?php echo esc_html( $args['button_title'] ); ?>
    </button>
    <?php if ( ! isset( $args['preview'] ) || ! $args['preview'] ) : ?>
        <button type="button"class="button csmf--a-btn csmf--a-btn-danger csmf--upload-remove <?php echo esc_attr( $hidden_class ); ?>">
            <?php echo esc_html($args['remove_title']); ?>
        </button>
    <?php endif; ?>
</div>
<div class="csmf--input-wrap">
    <input 
        type="hidden" 
        class="csmf--media-id"
        name="<?php echo esc_attr( "{$name}[id]" ); ?>" 
        value="<?php echo esc_attr( $value['id'] ); ?>">
    <input 
        type="hidden"
        class="csmf--media-thumbnail"
        name="<?php echo esc_attr( "{$name}[thumbnail]" ); ?>" 
        value="<?php echo esc_attr( $value['thumbnail'] ); ?>" >
    <input 
        type="hidden"
        class="csmf--media-alt" 
        name="<?php echo esc_attr( "{$name}[alt]" ); ?>" 
        value="<?php echo esc_attr( $value['alt'] ); ?>" >
    <input 
        type="hidden" 
        class="csmf--media-title"
        name="<?php echo esc_attr( "{$name}[title]" ); ?>" 
        value="<?php echo esc_attr( $value['title'] ); ?>">
    <input 
        type="hidden" 
        class="csmf--media-description"
        name="<?php echo esc_attr( "{$name}[description]" ); ?>" 
        value="<?php echo esc_attr( $value['description'] ); ?>">

    <input 
        type="hidden" 
        class="csmf--media-width"
        name="<?php echo esc_attr( "{$name}[width]" ); ?>" 
        value="<?php echo esc_attr( $value['width'] ); ?>">
    <input 
        type="hidden" 
        class="csmf--media-height"
        name="<?php echo esc_attr( "{$name}[height]" ); ?>" 
        value="<?php echo esc_attr( $value['height'] ); ?>">
</div>