<div class="cmf--upload-preview <?php echo !$src ? esc_attr( 'hidden' ) : ''; ?>">
	<div class="cmf--image-preview">
		<span class="cmf--upload-remove-wrap">
			<i class="cmf--upload-remove fas fa-times"></i>
		</span>
		<img class="cmf--upload-preview-img" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $args['alt'] ?? 'Media' ); ?>" />
	</div>
</div>
