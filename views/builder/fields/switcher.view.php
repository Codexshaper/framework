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

<label class="cxf--switcher">
    <input 
        type="checkbox" 
        class="switcher-input"
        name="<?php echo esc_attr( $name ); ?>" 
        value="1" 
        <?php cxf_get_string_attributes( $attributes ); ?>
        <?php checked( $value, true ); ?>
    >
    <span 
        class="switcher-label" 
        data-on="<?php echo esc_attr( $field['text_on'] ?? 'On' ); ?>" 
        data-off="<?php echo esc_attr( $field['text_off'] ?? 'Off'); ?>"
    ></span>
    <span class="switcher-indicator"></span>
</label>

<?php if(isset($field['label']) && $field['label']): ?>
    <span class="cxf--label"><?php echo esc_html( $field['label'] ); ?></span>
<?php endif; ?>