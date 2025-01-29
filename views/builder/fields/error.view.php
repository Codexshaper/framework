<?php if ( is_string( $errors ) ) : ?>
	<p class="cxf--error-text"><?php echo esc_html( $errors ); ?></p>
<?php endif; ?>

<?php if ( is_array( $errors ) ) : ?>
	<?php foreach ( $errors as $error ) : ?>
		<p class="cxf--error-text"><?php echo esc_html( $errors ); ?></p>
	<?php endforeach; ?>
<?php endif; ?>
