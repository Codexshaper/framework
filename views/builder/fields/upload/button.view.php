<div class="cmf--fieldset-wrap">
	<input 
		type="text" 
		name="<?php echo esc_attr( $name ); ?>" 
		value="<?php echo esc_attr( $value ); ?>" 
		class="cmf--upload-input" 
		<?php cmf_get_string_attributes( $attributes ); ?> >

	<button 
		type="button" 
		class="button cmf--a-btn cmf--a-btn-primary cmf--upload-button" 
		data-library="<?php echo esc_attr( $library ); ?>">
		<?php echo esc_html( $args['button_title'] ); ?> 
	</button>
	<button 
		type="button" 
		class="button cmf--a-btn cmf--a-btn-danger cmf--upload-remove <?php echo ! $value ? esc_attr( 'hidden' ) : ''; ?>">
		<?php echo esc_html( $args['remove_title'] ); ?>
	</button>
</div>
