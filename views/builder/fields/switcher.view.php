<?php
/**
 * Switcher View
 *
 * @category   View
 * @package    CodexShaper_Framework
 * @author     CodexShaper <info@codexshaper.com>
 * @license    https://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://codexshaper.com
 * @since      1.0.0
 * @version    1.0.0
 */
?>

<div class="cxf--switcher">
    <label class="cxf-module-activation-switch">
        <input 
            type="checkbox" 
            class="cxf-module-activation-input"
            name="<?php echo esc_attr( $name ); ?>" 
            value="1" 
            <?php cxf_get_string_attributes( $attributes ); ?>
            <?php checked( $value, true ); ?>
    >
        <span 
            class="active-label" 
            data-on="<?php echo esc_html__( $field['text_on'] ?? 'On', 'codexshaper-framework' ); ?>" 
            data-off="<?php echo esc_html__( $field['text_off'] ?? 'Off', 'codexshaper-framework' ); ?>"></span>
        <span class="activation-handler"></span>
    </label>
</div>

<?php if(isset($field['label']) && $field['label']): ?>
    <span class="cxf--label"><?php echo esc_html__( $field['label'] ); ?></span>
<?php endif; ?>