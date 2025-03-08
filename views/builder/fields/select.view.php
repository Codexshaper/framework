<?php
/**
 * Select View
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

<select 
	class="<?php echo $is_choice ? 'csmf--choice' : ''?>"
	name="<?php echo esc_attr( $name ); ?>"
	<?php echo esc_attr( $multiple_attr ); ?>
	<?php echo $placeholder_attr; ?>
	<?php csmf_get_string_attributes( $attributes ); ?>
>
	<?php if ( $args['placeholder'] && empty( $args['multiple'] ) ) :?>
		<option value=""><?php echo esc_html( $args['placeholder'] ); ?></option>
	<?php endif; ?>
	
	<?php foreach ( $options as $option_key => $option ) : ?>
		<?php $selected = ( in_array( $option_key, (array) $value ) ) ? ' selected' : ''; ?>
		<!-- Only option -->
		<?php if ( ! is_array( $option ) ) : ?>
			<option value="<?php echo esc_attr( $option_key ); ?>" <?php echo esc_attr( $selected ); ?>>
				<?php echo esc_attr( $option ); ?>
			</option>
			<?php continue; ?>
		<?php endif; ?>
		<!-- If has option group -->
		<optgroup label="<?php echo esc_attr( $option_key ); ?>">
			<?php foreach ( $option as $optgroup_key => $optgroup_value ) : ?>
				<?php $selected = ( in_array( $optgroup_key, (array) $value ) ) ? ' selected' : ''; ?>
					<option value="<?php echo esc_attr( $optgroup_key ); ?>" <?php echo esc_attr( $selected ); ?>>
						<?php echo esc_attr( $optgroup_value ); ?>
					</option>
				<?php endforeach; ?>
		</optgroup>
	<?php endforeach ?>
</select>
