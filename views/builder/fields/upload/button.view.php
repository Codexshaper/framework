<div class="cxf--fieldset-wrap">
	<input 
		type="text" 
		name="<?php echo esc_attr( $name ); ?>" 
		value="<?php echo esc_attr( $value ); ?>" 
		class="cxf--upload-input" 
		<?php cxf_get_string_attributes( $attributes ); ?> >

	<button 
		type="button" 
		class="button cxf--a-btn cxf--a-btn-primary cxf--upload-button" 
		data-library="<?php echo esc_attr( $library ); ?>">
		<?php echo esc_html( $args['button_title'] ); ?> 
	</button>
	<button 
		type="button" 
		class="button cxf--a-btn cxf--a-btn-danger cxf--upload-remove <?php echo ! $value ? esc_attr( 'hidden' ) : ''; ?>">
		<?php echo esc_html( $args['remove_title'] ); ?>
	</button>
</div>
