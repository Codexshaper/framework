<?php
/**
 * Upload Button View
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

<div class="csmf--fieldset-wrap">
	<input 
		type="text" 
		name="<?php echo esc_attr( $name ); ?>" 
		value="<?php echo esc_attr( $value ); ?>" 
		class="csmf--upload-input" 
		<?php csmf_get_string_attributes( $attributes ); ?> >

	<button 
		type="button" 
		class="button csmf--a-btn csmf--a-btn-primary csmf--upload-button" 
		data-library="<?php echo esc_attr( $library ); ?>">
		<?php echo esc_html( $args['button_title'] ); ?> 
	</button>
	<button 
		type="button" 
		class="button csmf--a-btn csmf--a-btn-danger csmf--upload-remove <?php echo ! $value ? esc_attr( 'hidden' ) : ''; ?>">
		<?php echo esc_html( $args['remove_title'] ); ?>
	</button>
</div>
