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

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<label class="csmf--switcher" <?php echo isset($field['width']) && $field['width'] ? 'style="width: ' . $field['width'] . 'px;"' : ''; ?>>
    <input 
        type="checkbox" 
        class="switcher-input"
        name="<?php echo esc_attr( $name ); ?>" 
        value="1" 
        <?php csmf_get_string_attributes( $attributes ); ?>
        <?php checked( $value, true ); ?>
    >
    <span 
        class="switcher-label" 
        data-on="<?php echo esc_html__( $field['text_on'] ?? 'On', 'codexshaper-framework' ); ?>" 
        data-off="<?php echo esc_html__( $field['text_off'] ?? 'Off', 'codexshaper-framework' ); ?>"
    ></span>
    <span class="switcher-indicator"></span>
</label>

<?php if(isset($field['label']) && $field['label']): ?>
    <span class="csmf--label"><?php echo esc_html__( $field['label'] ); ?></span>
<?php endif; ?>