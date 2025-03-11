<?php
/**
 * Text View
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

<input 
    type="<?php echo esc_attr( $type ); ?>" 
    name="<?php echo esc_attr( $name ); ?>" 
    value="<?php echo esc_attr( $value ); ?>"
    <?php cxf_get_string_attributes($attributes); ?> 
/>